<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\TestModel;
use App\TheLoai;
 
Route::get('/', function () {
    return view('welcome');
});

// 04/24
Route::get('QueryBuilder',function(){
	$kq = DB::table('Test')->where('id',1)->value('Name');
	var_dump($kq);
});

Route::get('TestModel',function(){
	echo TestModel::find(1)->Name;
});

// 25/04
Route::get('testgetLoaiTinFromTheLoai/{n}',function($n){
	$kq = TheLoai::find($n);  //lay the loai
	echo 'Ten the loai: '.$kq->Ten."<br/><br/>";
	$ltlist = $kq->LoaiTin;  //lay danh sach cua the loai tren
	// var_dump($ltlist);

	// lay tung loai tin cua danh sach tren
	foreach ($ltlist as $loaitin) {
		echo $loaitin->Ten."<br/>";
	}
});
// 26/04
// test hien thi trang admin
Route::get('test_admin',function(){
	return view('admin.theloai.danhsach');
});
// 27/04
// group Route de truy cap
Route::group(['prefix'=>'admin'],function(){
	Route::group(['prefix'=>'theloai'],function(){
		Route::get('danhsach','TheLoaiController@getDanhsach');

		Route::get('sua/{id}','TheLoaiController@getSua');
		Route::post('sua/{id}','TheLoaiController@postSua');

		Route::get('them','TheLoaiController@getThem');
		Route::post('them','TheLoaiController@postThem');

		Route::get('xoa/{id}','TheLoaiController@getXoa');
		// Route::post('xoa','TheLoaiController@postXoa');
	});

	Route::group(['prefix'=>'loaitin'],function(){
		Route::get('danhsach','LoaiTinController@getDanhsach');

		Route::get('sua/{id}','LoaiTinController@getSua');
		Route::post('sua/{id}','LoaiTinController@postSua');

		Route::get('them','LoaiTinController@getThem');
		Route::post('them','LoaiTinController@postThem');

		Route::get('xoa/{id}','LoaiTinController@getXoa');
	});

	Route::group(['prefix'=>'layout'],function(){
		Route::get('danhsach','TheLoaiController@getDanhsach');

		Route::get('sua','TheLoaiController@getSua');

		Route::get('them','TheLoaiController@getThem');
	});

	Route::group(['prefix'=>'tintuc'],function(){
		//admin/theloai/sua...
		Route::get('danhsach','TintucCler@getDanhSach');

		Route::get('sua/{id}','TintucCler@getSua');
		Route::post('sua/{id}','TintucCler@postSua');

		Route::get('them','TintucCler@getThem');
		Route::post('postthem','TintucCler@postThem');

		Route::get('xoa/{id}','TintucCler@getXoa');
		
	});

	Route::group(['prefix' => 'ajax'],function(){
		Route::get('loaitin/{idTheLoai}','AjaxCler@getLoaiTin');
	});
	
	Route::group(['prefix'=>'slide'],function(){
		Route::get('danhsach','SlideController@getDanhsach');

		Route::get('sua/{id}','SlideController@getSua');
		Route::post('sua/{id}','SlideController@postSua');

		Route::get('them','SlideController@getThem');
		Route::post('them','SlideController@postThem');

		Route::get('xoa/{id}','SlideController@getXoa');
	});

	Route::group(['prefix'=>'user'],function(){
 		Route::get('danhsach','UserController@getDanhSach');

 		Route::get('sua/{id}','UserController@getSua');
 		Route::post('sua/{id}','UserController@postSua');

 		Route::get('them','UserController@getThem');
 		Route::post('postthem','UserController@postThem');

 		Route::get('xoa/{id}','UserController@getXoa');
 	});
});