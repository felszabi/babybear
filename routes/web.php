<?php


use App\Http\Controllers\FeedController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
/*
Route::get('/products', function() {
	return view('products');
})->middleware(['auth', 'verified'])->name('products');
*/
Route::middleware(['auth','verified'])->group(function(){
    Route::get('/feed', [FeedController::class,'index'])->name('feed');
    Route::get('/feed/create', [FeedController::class,'create'])->name('feed.create');
    Route::post('/feed', [FeedController::class,'store'])->name('feed.store');
    Route::delete('/feed/destroy/{feed}', [FeedController::class,'destroy'])->name('feed.destroy');
    Route::get('/feed/edit/{feed}', [FeedController::class,'edit'])->name('feed.edit');
    Route::post('/feed/update/{feed}', [FeedController::class,'update'])->name('feed.update');
    Route::get('/feed/download/{feed}', [FeedController::class,'download'])->name('feed.download');
    Route::get('/feed/load/{feed}', [FeedController::class,'load'])->name('feed.load');
    Route::get('/feed/connentedcols/{feed}', [FeedController::class,'connentedcolsindex'])->name('feed.connentedcolsindex');
    Route::get('/feed/colsamplelist/{feed}/{col}', [FeedController::class,'colsamplelist'])->name('feed.colsamplelist');
    Route::post('/feed/updatecols/{feed}', [FeedController::class,'updatecols'])->name('feed.updatecols');
    Route::post('/feed/upload/{feed}', [FeedController::class,'upload'])->name('feed.upload');
    
    Route::get('/import', [ProductController::class,'importindex'])->name('import.index');
    
    Route::get('/import/addnew/{feed}', function(string $feed){
        return redirect()->route('import.addnew', ['feed'=> $feed, 'nth' => 0]);
    })->name('import.new');
    
    Route::get('/import/addnew/{feed}/{nth}', [ProductController::class,'importaddnew'])->name('import.addnew');
    //  import lépés új termékek hozzáadása
    
    // csak akkor adjuk hozzá ha nincs még az adatbázisban
    // id_sku_babybearId in_array keycolumn

    Route::get('/import/categories/{feed}', [ProductController::class,'importCategories'])->name('import.categories');

    Route::get('/import/connect-category/{feed}/{nth}', [ProductController::class,'importcategoryconnect'])->name('import.categoryconnect');

    Route::post('/import/new-category/{feed}/{nth}', [ProductController::class,'addcategory'])->name('category.add');
    // megáll ha nincs kategória társítva

    // ismeretlen betűre is álljon meg, szedje ki a html-t
    
    // ha valahol megáll lehessen tovább ugrani döntés nélkül

    Route::get('/export/all', [ProductController::class,'exportall'])->name('export.allproducts');

Route::get('/export/allimage', [ProductController::class,'createimagelisttxt'])->name('export.allproductimages');


    Route::get('/products', [ProductController::class,'create'])->name('products');
    Route::post('/products', [ProductController::class,'store'])->name('product.store');
    Route::get('/productlist', [ProductController::class,'index'])->name('productlist');

    Route::get('/category', [CategoryController::class,'index'])->name('category');


    Route::get('/attribute', [AttributeController::class, 'index'])->name('attribute.set');
    Route::post('/attribute', [AttributeController::class, 'store'])->name('attribute.new');
    Route::get('/attribute/{attributeid}', [AttributeController::class, 'edit'])->name('attribute.edit');
    Route::post('/attribute/{attributeid}', [AttributeController::class, 'update'])->name('attribute.update');
    Route::get('/attribute/{attributeid}/delete', [AttributeController::class, 'destroy'])->name('attribute.destroy');

    Route::get('/attribute/{attributeid}/item', [AttributeItemController::class, 'index'])->name('attributeitem.set');
    Route::post('/attribute/{attributeid}/item', [AttributeItemController::class, 'store'])->name('attributeitem.new');
    Route::get('/attributeitem/{itemid}', [AttributeItemController::class, 'edit'])->name('attributeitem.edit');
    Route::post('/attributeitem/{itemid}', [AttributeItemController::class, 'update'])->name('attributeitem.update');
    Route::get('/attributeitem/{itemid}/delete', [AttributeItemController::class, 'destroy'])->name('attributeitem.destroy');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
