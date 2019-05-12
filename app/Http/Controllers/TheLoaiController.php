<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Theloai;

class TheLoaiController extends Controller
{
    public function getDanhsach(){

    	$data = TheLoai::all();  //lay toan bo the loai tu Model
    	return view('admin.theloai.danhsach',['dsTheLoai'=>$data]);
    }

    // Them
    public function getThem(){
    	return view('admin.theloai.them');
    }

	public function postThem(Request $request){
		// xu ly xac nhan; kiem tra tinh hop le; validation
		$this->validate($request,
	    	[
	    		'Ten' => 'required|min:3|max:30|unique:TheLoai'
	    	],
	    	[
	    		'requir ed'=>'Ban chua nhap ten the loai',
	    		'min'=>'Tên thể loại phải có độ dài từ 3 đến 30 kí tự',
	    		'max'=>'Tên thể loại phải có độ dài từ 3 đến 30 kí tự',
	    		'unique'=>'Tên thể loại này đã tồn tại'
	    	]);
		$theloai = new Theloai();
		$theloai->Ten = $request->Ten;
		$theloai->TenKhongDau = changeTitle($request->Ten);
		// $theloai->createg_at = new DateTime();
		// luu vao csdl
		$theloai->save();

		// chuyen huong toi view them
		return redirect('admin/theloai/them')->with('thongbao','Da them thanh cong');
	}

	// Sua
	public function getSua($id){
		$theloai = TheLoai::find($id);
		return view('admin.theloai.sua',['theloai'=>$theloai]);
	}
	public function postSua(request $request,$id){
		$theloai = TheLoai::find($id);
		$this->validate($request,
			[
	    		'Ten' => 'required|min:3|max:30|unique:TheLoai'
	    	],
	    	[
	    		'required'=>'Ban chua nhap ten the loai',
	    		'min'=>'Tên thể loại phải có độ dài từ 3 đến 30 kí tự',
	    		'max'=>'Tên thể loại phải có độ dài từ 3 đến 30 kí tự',
	    		'unique'=>'Tên thể loại này đã tồn tại'
	    	]
		);
		$theloai->Ten = $request->Ten;
		$theloai->TenKhongDau = changeTitle($request->Ten,"-",MB_CASE_TITLE);
		$theloai->save();
		return redirect('admin/theloai/sua/'.$id)->with('thongbao','Đã sửa thành công');
	}

	// Xóa
	public function getXoa($id){
		$theloai = TheLoai::find($id);  //yêu cầu model tìm id cần xóa
		$ten = $theloai->Ten;
		$theloai->delete();

		return redirect('admin/theloai/danhsach')->with('thongbao',"Đã xóa $ten thành công");
	
	}
}
