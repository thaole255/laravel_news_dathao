<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\Theloai;

class LoaiTinController extends Controller
{
    public function getDanhSach(){
    	// Lấy tất cả danh sách Loại tin -> view admin.loaitin.danhsach
    	$data = LoaiTin::all(); // Lấy toàn bộ thể loại từ Model
    	return view('admin.loaitin.danhsach',['dsLoaiTin'=>$data]);
    }
    public function getThem(){
        $dsTheLoai = TheLoai::all();
    	return view('admin.loaitin.them',['dsTheLoai'=>$dsTheLoai]);
    }
    public function postThem(Request $req){
        // xử lý xác nhận/ kiểm tra tính hợp lệ; validation
        $this->validate($req
            ,['Ten'=>'required|min:3|max:30|unique:LoaiTin,Ten',
            'TheLoai'=>'required']
            ,[  'Ten.required'=>'Tên không được để trống'
                ,'Ten.min'=>'Độ dài phải > 3'
                ,'Ten.max'=>'Độ dài phải < 30'  
                ,'Ten.unique'=>'Loại tin này đã tồn tại'
                ,'TheLoai.required'=>'Thể loại không được để trống'
            ]
        );
        //Tạo model loại tin
    	$loaitin = new LoaiTin();
        $loaitin->Ten = $req->Ten;
        $loaitin->TenKhongDau = changeTitle($req->Ten);
        $loaitin->idTheLoai = $req->TheLoai;
        // $loaitin->created_at = new DateTime();
        //lưu vào CSDL
        $loaitin->save();

        //chuyển hướng tới view them
        return redirect('admin/loaitin/them')->with('thongbao','Đã thêm thành công');
    }   
    public function getSua($id) {
        // yêu cầu Model lấy thể loại ra 
        $loaitin = LoaiTin::find($id);
        $dsTheLoai = TheLoai::all();
        return view('admin.loaitin.sua',['loaitin'=>$loaitin,'dsTheLoai'=>$dsTheLoai]);

    }
    public function postSua(Request $req,$id) {
        // yêu cầu Model lấy thể loại ra 
        $loaitin = LoaiTin::find($id);
        //validate dữ liệu trong Request
        $this->validate($req
            ,['Ten'=>'required|min:3|max:30']
            ,[  'required'=>'Trường này không được để trống'
                ,'min'=>'Độ dài phải > 3'
                ,'max'=>'Độ dài phải < 30'
            ]
        );
        $loaitin->Ten = $req->Ten;
        $loaitin->TenKhongDau = changeTitle($req->Ten,'-',MB_CASE_TITLE);
        $loaitin->idTheLoai = $req->TheLoai;
        $loaitin->save();
        return redirect('admin/loaitin/sua/'.$id)->with('thongbao','Đã sửa thể loại thành công');
        
    }
    function getXoa($id){
        $loaitin = LoaiTin::find($id);
        $ten = $loaitin->Ten;
        $loaitin->delete();
        return redirect('admin/loaitin/danhsach')->with('thongbao',"Bạn đã xóa thành công Loại tin : $ten");
    }
}
