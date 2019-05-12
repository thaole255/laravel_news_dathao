<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tintuc;
use App\Theloai;
use App\Loaitin;

class TintucCler extends Controller
{
    public function getDanhSach()
    {
    	//lấy tất cả từ model
    	$tintuc = Tintuc::orderBy('id','DESC')->get();
    	// lấy tất cả danh sách Thể loại -> view('admin.Tintuc.danhsach')
    	return view('admin.tintuc.danhsach',['dsTinTuc' => $tintuc]);
    }

    public function getThem()
    {
        $dsTheLoai = Theloai::all();
    	$dsLoaiTin = Loaitin::all();
        return view('admin.tintuc.them',['dsTheLoai' => $dsTheLoai,
                                        'dsLoaiTin' => $dsLoaiTin]);
    }

     public function postThem(Request $req)
    {	
    	
    	$this->validate($req,			//hàm bắt lỗi dũ liệu
    		[
    			'LoaiTin'	=> 'required|unique:LoaiTin,Ten',
                'TieuDe'    => 'required|min:3|unique:TinTuc,TieuDe',
                'TomTat'    => 'required',
                'NoiDung'   => 'required'
    		],
    		[
                'LoaiTin.required'  => 'Bạn chưa chọn loại tin',
    			'TieuDe.required'	=> 'Bạn chưa nhập tiêu đề',
    			'TieuDe.min'		=> 'Độ dài tiêu đề phải lớn hơn 3 ký tự',
    			'TieuDe.unique' 	=> 'Tiêu đề đã tồn tại',
                'TomTat.required'   => 'Bạn chưa nhập tóm tắt',
                'NoiDung.required'  => 'Bạn chưa nhập nội dung'
    		]
    	);
    	
    	//Tạo model loại tin;
    	$tintuc = new Tintuc();
    	$tintuc->TieuDe = $req->TieuDe;
    	$tintuc->TieuDeKhongDau = changeTitle($req->TieuDe);
        $tintuc->idLoaiTin = $req->LoaiTin;
        //$tintuc->idTheLoai = $req->Theloai;
        $tintuc->TomTat = $req->TomTat;
        $tintuc->NoiDung = $req->NoiDung;
        $tintuc->SoLuotXem = 0;

        if($req->hasFile('Hinh')){
            $file = $req->file('Hinh');//$tintuc->Hinh =
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg'){
                return redirect('admin/tintuc/postthem')->with('loi','Bạn chỉ được chọn file có đuôi jpg,png,jpeg');
            }
            $name = $file->getClientOriginalName();
            $Hinh = str_random(4)."_".$name;
            while(file_exists("upload/tintuc/".$Hinh))
            {
                $Hinh = str_random(4)."_".$name;
            }
            $file->move("upload/tintuc",$Hinh);
            $tintuc->Hinh = $Hinh;
        }
        else
            $tintuc->Hinh = "";
    	$tintuc->save();
    	return redirect('admin/tintuc/them')->with('Thongbao','Đã thêm thành công');
    // }
    }

    public function getSua($id)
    {
    	$tintuc = Tintuc::find($id);
        $dsTheLoai = Theloai::all();
        $dsLoaiTin = Loaitin::all();
    	return view('admin.tintuc.sua',['tintuc' => $tintuc,'dsTheLoai'=>$dsTheLoai,'dsLoaiTin'=>$dsLoaiTin]);
    }

    public function postSua(Request $req,$id)
    {
    	$tintuc = Tintuc::find($id);
    	$this->validate($req,          //hàm bắt lỗi dũ liệu
            [
                'LoaiTin'   => 'required|unique:LoaiTin,Ten',
                'TieuDe'    => 'required|min:3|unique:TinTuc,TieuDe',
                'TomTat'    => 'required',
                'NoiDung'   => 'required'
            ],
            [
                'LoaiTin.required'  => 'Bạn chưa chọn loại tin',
                'TieuDe.required'   => 'Bạn chưa nhập tiêu đề',
                'TieuDe.min'        => 'Độ dài tiêu đề phải lớn hơn 3 ký tự',
                'TieuDe.unique'     => 'Tiêu đề đã tồn tại',
                'TomTat.required'   => 'Bạn chưa nhập tóm tắt',
                'NoiDung.required'  => 'Bạn chưa nhập nội dung'
            ]
        );
    	$tintuc->TieuDe = $req->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($req->TieuDe);
        $tintuc->idLoaiTin = $req->LoaiTin;
        //$tintuc->idTheLoai = $req->Theloai;
        $tintuc->TomTat = $req->TomTat;
        $tintuc->NoiDung = $req->NoiDung;

        if($req->hasFile('Hinh')){
            $file = $req->file('Hinh');//$tintuc->Hinh =
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg'){
                return redirect('admin/tintuc/postthem')->with('loi','Bạn chỉ được chọn file có đuôi jpg,png,jpeg');
            }
            $name = $file->getClientOriginalName();
            $Hinh = str_random(4)."_".$name;
            while(file_exists("upload/tintuc/".$Hinh))
            {
                $Hinh = str_random(4)."_".$name;
            }
            $file->move("upload/tintuc",$Hinh);
            unlink("upload/tintuc/".$tintuc->Hinh);
            $tintuc->Hinh = $Hinh;
        }
        
        $tintuc->save();

    	return redirect('admin/tintuc/sua/'.$id)->with('Thongbao','Sửa Thành công');
    }

    public function getXoa($id)
    {
    	//yêu cầu model tìm thằng có id cần xóa
    	$tintuc = Tintuc::find($id);
    	$tintuc->delete();
    	return redirect('admin/tintuc/danhsach')->with('thongbao','Xóa tin tức thành công');
    }



}
