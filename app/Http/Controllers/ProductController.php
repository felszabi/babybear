<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Feed;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Shuchkin\SimpleXLSX;
use Illuminate\Support\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::paginate(50);
        $product = $products->first();
        $productskeys = $product===null? false : array_keys($product->toArray());

        return view('product.list', ['products'=> $products, 'productskeys' => $productskeys]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required','string', 'max:255'],
            'price' => ['required', 'decimal:0,2', 'min:1']
        ]);

        $product = Product::create([
            'name' => $request->name,
            'sku' => $request->sku,
            'price' => $request->price,
            'ean' => 'asd',
            'status' => 1
        ]);
        return $this::index();
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function importindex()
    {
        return view('import.list', ['listitems'=> Feed::paginate(20), 'files' => Storage::files('feedasset')]);
    }

    public function import(Feed $feed)
    {
        $keycolumn = $feed->keycolumn;
        $find = Product::where('connection', $feed->name)->where('connection_key', $loadedProduct->$keycolumn );
        if($find->count() > 1){
            // error
        }else{
            if($find->count() > 0){
                // updatefromfeed $find->first();
            }else{
                // storefromfeed
            }
        }
        
    }

    public function createimagelisttxt()
    {
        $products = Product::get();
        $rows = array();
        foreach($products as $product){
            $images= array();
            $unasid = $product->id."_".$product->sku."_".$product->connection;
            if(!is_null($product->index_image)){
                $images = json_decode($product->index_image, true);
            }
            if(!empty($images)){
                foreach ($images as $imagekey => $src) {
                    if($imagekey == 0){
                        $rows[] =  $unasid.".jpg"." ". $src; 
                    }else{
                        $rows[] = $unasid."_altpic_".$imagekey.".jpg". " ".$src; 
                    }
                }
            }
        }
        foreach ($rows as $row){
            echo $row."\r\n";
        }
    }

    public function importaddnew(Feed $feed, $nth){
        //csináljon meg 30 darabot, vagy kérdezzen előtte, majd töltse ujra
        $step = 20000;
        $feedPath = 'feedasset/'.$feed->filename;

        if(Storage::exists($feedPath)){
            $fileExtension = File::extension($feedPath);
            $allowedFileExtensions = array('xml','xls','xlsx','csv');
            if(!in_array($fileExtension, $allowedFileExtensions)){
                return false; // hiba szöveget kellene küldeni
            }
            
            if($fileExtension == 'xml'){ // XML
                $content = Storage::get($feedPath);
                $xml = simplexml_load_string($content);
                if($xml === false){

                }else{
                    $rownth = 0;
                    foreach($xml as $row){
                        if($nth <= $rownth && $nth+$step > $rownth){
                           
                           $product = array();
                           $columnNames = array();
                           foreach($row as $col){
                             $product[$col->getName()] = $col;
                             $columnNames[] = $col->getName();
                           }
                           if(!$this::importproduct($feed,$product,$columnNames)){
                                $connectedcols = json_decode($feed->connentedcols,true);
                                $categorycol = 0;
                                foreach($connectedcols as $col => $connect){
                                    if($connect == 'category'){
                                        $categorycol = $col;
                                    }
                                }

                                return view('import.categoryconnect', ['feed' => $feed, 
                                    'nth' => $rownth, 
                                    'categories' => Category::orderBy('name')->get(),
                                    'category' => $product[$categorycol] ]);
                           }
                           
                        }

                        
                        $rownth++;

                    }
                    $next = $nth+$step;
                    echo 'kész összesen:'. $rownth. ' db';
                    //return redirect(route('import.addnew', ['feed'=>$feed,'nth'=>$next]));
                    
                }
                
            }

            if($fileExtension == 'xls' || $fileExtension == 'xlsx'){
                $path = Storage::path($feedPath);
                $parsedData = SimpleXLSX::parse($path);
                
                if($parsedData != false){
                    $rows = $parsedData->rows();
                     $columnNames = array_shift($rows);
                    $max = count($rows)+1;
                    if($nth+$step < $max){
                        $max = $nth+$step;
                    }
                    for($i=$nth;$i<$max;$i++){
                        if(!$this::importproduct($feed, $rows[$i],$columnNames)){
                            $connectedcols = json_decode($feed->connentedcols,true);
                            $categorycol = 0;
                            $cnt = 0;
                            foreach($connectedcols as $col => $connect){
                                if($connect == 'category'){
                                    $categorycol = $cnt;
                                }
                                $cnt++;
                            }
                            return view('import.categoryconnect', ['feed' => $feed, 
                                'nth' => $i, 
                                'categories' => Category::orderBy('name')->get(),
                                'category' => $rows[$i][$categorycol] ]);
                        }
                    }
                }
            }

        }
    }

    public function importCategories(Feed $feed)
    {
        $feedPath = 'feedasset/'.$feed->filename;

        if(Storage::exists($feedPath)){
            $fileExtension = File::extension($feedPath);
            $allowedFileExtensions = array('xml','xls','xlsx','csv');
            if(!in_array($fileExtension, $allowedFileExtensions)){
                return false; // hiba szöveget kellene küldeni
            }
            
            

            if($fileExtension == 'xls' || $fileExtension == 'xlsx'){
                $path = Storage::path($feedPath);
                $parsedData = SimpleXLSX::parse($path);
                
                if($parsedData != false){
                    $rows = $parsedData->rows();
                     $columnNames = array_shift($rows);
                     $categoryKey = 2;
                     /*
                    for($i = 0; $i < count($columnNames) ; $i++){
                        if($columnNames[$i] == "Kategória név/nevek"){
                            $categoryKey = $i;
                        }
                    }*/

                    foreach($rows as $row){
                        if(strpos($row[$categoryKey], ";")){
                            $arr = explode(";", $row[$categoryKey]);
                            foreach($arr as $cat){
                                $this::importCategory($cat);
                            }
                        }else{
                            $this::importCategory($row[$categoryKey]);
                        }
                        
                    }
                    
                }
            }

        }
    }

    public function importCategory($category)
    {
        if(Category::where('foreign_name',$category)->count()==0){
            $foreign_name = $category;
            $categoryNewname = str_replace("/", "|", $category);
            $cat = Category::create([
                'name' => $categoryNewname,
                'foreign_name' => $foreign_name
            ]);
        }
    }

    public function categorySearch($category){
        $cat = Category::where('foreign_name',$category);
        if($cat->count()==1){
            return $cat->first()->name;
        }else{
            if($cat->count() > 0){
                return $cat->first()->name;
            }else{
               return false; 
            }
           
        }
    }

    public function addcategory(Feed $feed, $nth, StoreCategoryRequest $request)
    {
       
        $cat = Category::create([
                'name' => $request->category,
                'foreign_name' => $request->feedcategory
            ]);
        return redirect(route('import.addnew',['feed'=>$feed, 'nth' => $nth]));
    }

    public function importproduct(Feed $feed, array $product, array $names)
    {
        $columns = array();
        $productskeysIsNumeric = false;
        foreach($product as $key => $v){
            if(is_numeric($key)){
                $productskeysIsNumeric = true;
            }
        }
        if($productskeysIsNumeric){
            foreach($names as $key => $name){
                $columns[$name] = $product[$key];
            }
            $columnsearch = $this::columnsearchall($feed, $columns);
        }else{
            $columnsearch = $this::columnsearchall($feed, $product);
        }

        $searchProduct = Product::where('sku',$columnsearch['sku'])->where('connection',$feed->id)->count(); 
        // id(prog)_sku(feed)_connection(feed id)
        if($searchProduct > 0){
            $foundProduct = Product::where('sku',$columnsearch['sku'])->where('connection',$feed->id)->first();
            if($foundProduct->index_image === null){
                $productUnasId = $foundProduct->id."_".$foundProduct->sku."_".$feed->id;
                if($productskeysIsNumeric){
                    foreach($names as $key => $name){
                            $columns[$name] = $product[$key];
                    }
                    $columnsearch = $this::columnsearchall($feed, $columns,true);
                }else{
                    $columnsearch = $this::columnsearchall($feed, $product,true);
                }

                $imagearray = array();
                foreach($columnsearch['index_image'] as $images){
                    if(is_object($images)){
                        $images = (array) $images;
                        if(strlen($images[0]) >4){
                            $imagearray[] = $images[0];
                        }
                        
                         
                    }else{
                        if(strpos($images, "|||")){
                            array_push($imagearray,explode("|||",$images));
                        }else{
                            if(strlen($images)>4){
                                $imagearray[] = $images;
                            }
                            
                        }
                    }
                   
                    
                }
                if($feed->name == "diaper"){
                    $imagearrayTemp = $imagearray;
                    $imagearray = array();
                    foreach($imagearrayTemp as $i){
                        if(is_array($i)){
                            foreach($i as $im){
                                $imagearray[] = "https://diaper.cdn.shoprenter.hu/custom/diaper/image/cache/w700h700wt1/".$im;
                            }
                        }else{
                            $imagearray[] = "https://diaper.cdn.shoprenter.hu/custom/diaper/image/cache/w700h700wt1/".$i;
                        }
                        
                    }
                }
                if(!empty($imagearray)){
                    $foundProduct->index_image = json_encode($imagearray);
                    $foundProduct->save();
                }
                
            }
            

            // ar keszlet ellenorzes !!!
            // kép ellenőrzés
            return true;
        }else{
           if($foundCategory = $this::categorySearch($columnsearch['category'])){
                $newproduct = Product::create([
                    'name' => $columnsearch['name'],
                    'sku' => $columnsearch['sku'],
                    'price' => $columnsearch['price'],
                    'connection' => $feed->id,
                    'ean' => isset($columnsearch['ean'])?$columnsearch['ean']:'',
                    'manufacturer' => $columnsearch['manufacturer'],
                    'stock' => $columnsearch['stock'],
                    'category' => $foundCategory,
                    'description' => html_entity_decode($columnsearch['description']),
                    'status' => 1
                ]); 
           }else{
                return false;
           }
           
        return true;
        }
        
    }

    public function columnsearchall(Feed $feed,array $columns, $multiple = false)
    {
        $cols = json_decode($feed->connentedcols, true);
        $result = array();
        $schema = Schema::getColumnListing('products');
        foreach($cols as $key => $value){
            if(in_array($value,$schema)){
                if(!isset($columns[$key])){
                    $key = str_replace("_", " ", $key);
                    if(isset($columns[$key])){
                        if($multiple){
                            if(isset($result[$value]) && is_array($result[$value])){
                                $result[$value][] = $columns[$key];
                            }else{
                                if(isset($result[$value])){
                                    $temp = $result[$value];
                                    $result[$value] = array($temp);
                                    $result[$value][] = $columns[$key];
                                }else{
                                    $result[$value] = $columns[$key];
                                }
                            }
                        }else{
                            $result[$value] = $columns[$key];
                        }
                    }
                }else{
                    if($multiple){
                        if(isset($result[$value]) && is_array($result[$value])){
                            $result[$value][] = $columns[$key];
                        }else{
                            if(isset($result[$value])){
                                $temp = $result[$value];
                                $result[$value] = array($temp);
                                $result[$value][] = $columns[$key];
                            }else{
                                $result[$value] = $columns[$key];
                            }
                        }
                    }else{
                        $result[$value] = $columns[$key];
                    }
                    
                }
                
            }
        }
        return $result;
    }

    public function exportall()
    {
        $productArray = array();

        /**
         * Kategória !!!
         * Adat 1   (ean) !!!
         * Paraméter: Gyártó||textmore !!!
         * Raktárkészlet ???
         * */
        $productsAll = Product::get();
        foreach($productsAll as $p){
            $productArray[] = array('Cikkszám' => $p->id .'_'. $p->sku .'_'. $p->connection,
                                    'Termék Név' => $p->name,
                                    'Bruttó Ár' => intval($p->price),
                                    'Nettó Ár' => (intval($p->price)/1.27),
                                    'Rövid Leírás' => $p->short_description,
                                    'Tulajdonságok' => $p->description,
                                    //'Adat 1' => $p->ean,
                                    'Paraméter: Gyártó||textmore' => $p->manufacturer,
                                    'Raktárkészlet' => $p->stock,
                                    'Kategória' => $p->category  ); 
        }
        
        $UNASdatabaseId = 62930;

        $newPath = Storage::path('feedasset');
        $filename = 'productExport'.'.xml';
        $f = fopen($newPath."/".$filename,"w");
        fwrite($f,$this::getUnasXmlHeader($UNASdatabaseId, $productArray));
        $termekDarabszam = count($productArray);

        for($i=0;$i<$termekDarabszam;$i++){
       //     $xmlContent = getUnasXmlItem($productArray,$i);
            fwrite($f,$this::getUnasXmlItem($productArray,$i));
        }
       // $xmlFooter = getUnasXmlFooter();
        fwrite($f,$this::getUnasXmlFooter());
        fclose($f);

        die('exportUNAS xml kesz');
    }


    public function getUnasXmlHeader($databaseId, $createdProducts)
    {
        $result =  '<?xml version="1.0"?>'."\r".
            '<?mso-application progid="Excel.Sheet"?>'."\r".
            '<Workbook'."\r".
            '           xmlns="urn:schemas-microsoft-com:office:spreadsheet"'."\r".
            '           xmlns:o="urn:schemas-microsoft-com:office:office"'."\r".
            '           xmlns:x="urn:schemas-microsoft-com:office:excel"'."\r".
            '           xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"'."\r".
            '           xmlns:html="http://www.w3.org/TR/REC-html40">'."\r".
            '<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">'."\r".
            '   <Title>UnasShop Database - '.$databaseId.'</Title>'."\r".
            '   <Author>UNAS</Author>'."\r".
            '   <Created>2021-12-16T03:21:13Z</Created>'."\r".
            '   <Manager>UNAS</Manager>'."\r".
            '   <Company>UNAS</Company>'."\r".
            '   <Version>11.9999</Version>'."\r".
            '</DocumentProperties>'."\r".
            '<ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel" />'."\r".
            '<Styles>'."\r".
            '   <Style ss:ID="Default" ss:Name="Normal">'."\r".
            '       <Alignment ss:Vertical="Bottom"     />'."\r".
            '       <NumberFormat/>'."\r".
            '       <Protection/>'."\r".
            '   </Style>'."\r".
            '   <Style ss:ID="db_header" >'."\r".
            '       <Font  ss:Color="#0000ff" ss:Bold="1"       x:Family="Swiss"/>'."\r".
            '       <NumberFormat/>'."\r".
            '       <Protection/>'."\r".
            '   </Style>'."\r".
            '   <Style ss:ID="db_datetime" >'."\r".
            '       <NumberFormat ss:Format="mm/dd/yy\ hh:mm:ss"/>'."\r".
            '       <Protection/>'."\r".
            '   </Style>'."\r".
            '   <Style ss:ID="db_date" >'."\r".
            '       <NumberFormat ss:Format="mm/dd/yy"/>'."\r".
            '       <Protection/>'."\r".
            '   </Style>'."\r".
            '   <Style ss:ID="db_time" >'."\r".
            '       <NumberFormat ss:Format="hh:mm:ss"/>'."\r".
            '       <Protection/>'."\r".
            '   </Style>'."\r".
            '   <Style ss:ID="unas_header" >'."\r".
            '       <Alignment ss:Vertical="Center" ss:Horizontal="Center"    />'."\r".
            '       <Font ss:Size="12" ss:Color="Automatic" ss:Bold="1"       />'."\r".
            '       <Interior ss:Color="#c0c0c0" ss:Pattern="Solid" />'."\r".
            '       <NumberFormat/>'."\r".
            '       <Protection/>'."\r".
            '   </Style>'."\r".
            '</Styles>'."\r".
            '<Worksheet ss:Name="UnasShop Database - 85803" >'."\r".
            '   <Table>'."\r";
        $temp = $createdProducts[0];
        $num = 0;
        $cells = array();
        foreach ($temp as $key => $value){
            $num++;
            $result .= '<Column ss:Index="'.$num.'" ss:AutoFitWidth="0" ss:Width="99"/>'."\r";
            $cells[] = "\r".
                '<Cell ss:StyleID="unas_header" ss:Index="'.$num.'"   >'."\r".
                '<Data ss:Type="String">'.$key.'</Data>'."\r".
                '</Cell>';
        }
        
        $result .= ''."\r".
            '<Row ss:Index="1" ss:StyleID="unas_header" ss:AutoFitHeight="0" ss:Height="22.5"  >'."\r".
            implode(' ', $cells).'</Row>'."\r".
            ' ';
        
        return $result;
    }

    public function getUnasXmlItem($createdProducts,$arrayIndex=0)
    {
        $rowIndex = $arrayIndex+2;
        $result = "\r".'<Row ss:Index="'.$rowIndex.'"  >'."\r";
        $cellIndex = 0;
        foreach($createdProducts[$arrayIndex] as $key => $value){
            $cellIndex++;
            $result .= ''."\r".
                '<Cell  ss:Index="'.$cellIndex.'"   >'."\r".
                '   <Data ss:Type="String">'.$value.'</Data>'."\r".
                '</Cell>';
        }
        $result .= "\r".'</Row>'."\r";
        return $result;
    }

    public function getUnasXmlFooter()
    {
        return "\r".
            '</Table>'."\r".
            '<WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">'."\r".
            '               <FreezePanes/>'."\r".
            '               <FrozenNoSplit/>'."\r".
            '               <SplitHorizontal>1</SplitHorizontal>'."\r".
            '               <TopRowBottomPane>1</TopRowBottomPane>'."\r".
            '                   <SplitVertical>2</SplitVertical>'."\r".
            '               <LeftColumnRightPane>2</LeftColumnRightPane>'."\r".
            '               <ActivePane>0</ActivePane>'."\r".
            '          <Panes>'."\r".
            '           <Pane>'."\r".
            '                <Number>3</Number>'."\r".
            '               </Pane>'."\r".
            '               <Pane>'."\r".
            '                <Number>1</Number>'."\r".
            '               </Pane>'."\r".
            '               <Pane>'."\r".
            '                <Number>2</Number>'."\r".
            '               </Pane>'."\r".
            '               <Pane>'."\r".
            '                <Number>0</Number>'."\r".
            '                <ActiveRow>5</ActiveRow>'."\r".
            '                <ActiveCol>0</ActiveCol>'."\r".
            '               </Pane>'."\r".
            '              </Panes>'."\r".
            '           </WorksheetOptions>'."\r".
            '</Worksheet>'."\r".
            '</Workbook>'."\r".
            '';
    }



}
