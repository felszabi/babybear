<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\StoreFeedRequest;
use App\Http\Requests\UpdateFeedRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Shuchkin\SimpleXLSX;
use Illuminate\Support\Carbon;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('feed.list', ['listitems'=> Feed::paginate(20), 'files' => Storage::files('feedasset')]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('feed.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeedRequest $request)
    {
        //
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'filename' => ['required','string', 'max:255'],
            'keycolumn' => ['required','string', 'max:255'],
            'pricemod' => ['required', 'decimal:0,2', 'min:0']
        ]);

        $feed = Feed::create([
            'name' => $request->name,
            'src' => $request->src,
            'filename' => $request->filename,
            'keycolumn' => $request->keycolumn,
            'pricemod' => $request->pricemod
        ]);
        return $this::index();
    }

    /**
     * Display the specified resource.
     */
    public function show(Feed $feed)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feed $feed)
    {
        //
        return view('feed.edit',['feed'=>$feed]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeedRequest $request, Feed $feed)
    {
        //
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'filename' => ['required','string', 'max:255'],
            'keycolumn' => ['required','string', 'max:255'],
            'pricemod' => ['required', 'decimal:0,2', 'min:0']
        ]);

        

        $feed->update($request->all());
        return redirect(route('feed'));
        return $this::index();

    }

    public function updatecols(UpdateFeedRequest $request, Feed $feed)
    {
        $colsNotToSave = array('_token', '_method');
        $cols = $request->all();
        foreach($colsNotToSave as $notsave){
            unset($cols[$notsave]);
        }
        $feed->connentedcols = json_encode($cols);
        $feed->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feed $feed)
    {
        //
        $feed->delete();
        return redirect()->route('feed');
    }

    /**
     * Download a feed file to storage
     */
    public function download(UpdateFeedRequest $request, Feed $feed)
    {
        
        if(!Storage::directoryExists('feedasset')){
            Storage::makeDirectory('feedasset');
        }
        
        Storage::put('feedasset/'.$feed->filename, file_get_contents($feed->src));
        $feed->downloaded = Carbon::now(env('DEFAULT_TIMEZONE'));
        $feed->save();
        return redirect(route('feed'));
    }

    public function upload(UpdateFeedRequest $request, Feed $feed)
    {
        $file = $request->file('feedfile')->storeAs('feedasset',$feed->filename);
        $feed->downloaded = Carbon::now(env('DEFAULT_TIMEZONE'));
        $feed->save();
    }

    public function load(Feed $feed)
    {   
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
                    /**
                     * hibakezelés
                    foreach(libxml_get_errors() as $error) {
                        echo "<br>", $error->message;
                    }
                    */
                }else{
                    if(json_decode($feed->connentedcols,true) ===null){
                        $namespaces = array();
                        foreach($xml as $row){
                            foreach($row as $col){
                                if(!in_array($col->getName(),$namespaces)){
                                    $namespaces[] = $col->getName();
                                }
                            }

                        }
                        $names = array();
                        foreach($namespaces as $n){
                            $names[$n] = 'unconnected';
                        }
                        $feed->connentedcols = json_encode($names);
                        $feed->save();
                    }else{
                        $names = json_decode($feed->connentedcols,true);
                        
                    }
                    return array('type' => 'xml',
                                'content' => $xml);
                }
            }
            if($fileExtension == 'xls' || $fileExtension == 'xlsx'){ // Excel
               $path = Storage::path($feedPath);
                $parsedData = SimpleXLSX::parse($path);
                
                if($parsedData != false){
                    
                    $rows = $parsedData->rows();
                    if(json_decode($feed->connentedcols,true) ===null){
                        $names = array();
                        foreach($rows[0] as $n){
                            $names[$n] = 'unconnected';
                        }
                        $feed->connentedcols = json_encode($names);
                        $feed->save();
                    }else{
                        $names = json_decode($feed->connentedcols,true);
                        
                    }
                    return array('type' => 'xls',
                                    'content' =>$rows);
                    
                }else{
                    echo SimpleXLSX::parseError();
                    die('nem sikerült betölteni');
                }
            }
            if($fileExtension == 'csv'){ // CSV

            }


        }   
    }

    public function connentedcolsindex(Feed $feed)
    {
        /**
         * unconnected = not paired
         * value = paired to column
         * attr-id = paired to attribute
         * false = should not paired
         * */
        $connentedcols = json_decode($feed->connentedcols,true);
        $columns = Schema::getColumnListing('products');
        $notPairableColumns= array(
            'id',
            'connection',
            'created_at',
            'updated_at',
            'status'
        );
        for($i=count($columns)-1;$i>-1;$i--){
            if(in_array($columns[$i],$notPairableColumns)){
                unset($columns[$i]);
            }
        }
        return view('feed.connentedcols',[
            'feed' => $feed,
            'connentedcols' => $connentedcols,
            'columns' => $columns,
            'attributes' => Attribute::all()]);
    }

    public function colsamplelist(Feed $feed, $col)
    {
        $loadedFeed = $this::load($feed);
        $loaded = array();
        $max = 100;
        if($loadedFeed['type'] == 'xml'){
            foreach($loadedFeed['content'] as $row){
                foreach($row as $column){
                    if($column->getName()== $col){
                        $n = $column->getName();
                        $loaded[] = $row->$n;
                        $max--; 
                    }
                }
                if($max<1){
                    break;
                }
            }
        }
        if($loadedFeed['type'] == 'xls'){
            $connectedcols = json_decode($feed->connentedcols,true);
            $arrayKey = 2;
            $nth = 0;
            foreach($connectedcols as $key =>$connect){
                if($key == $col){
                    $arrayKey = $nth;
                }
                $nth++;
            }
            foreach($loadedFeed['content'] as $row){
                $loaded[] = $row[$arrayKey];
                $max--;
                if($max<1){
                    break;
                }
            }
        }
        return view('feed.colsamplelist',['col' => $col, 'list' => $loaded]);
    }

     
}
