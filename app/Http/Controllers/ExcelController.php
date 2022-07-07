<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelController extends Controller
{
    function index()
    {
        $user = User::orderBy('id', 'DESC')->paginate(10);
        $products = ProductModel::orderBy('id', 'DESC')->paginate(10);
        $category = CategoryModel::orderBy('id', 'DESC')->get();
        return view('admin.product.import', ['data' => $user, 'products'=>$products, 'category'=>$category]);
    }

   function import_product(ImportExcelRequest $request)
    {
        $the_file = $request->file('uploaded_file');
        try {
            $spreadsheet = IOFactory::load($the_file->getRealPath());
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range(2, $row_limit);
            $column_range = range('F', $column_limit);
            $startcount = 2;
            $data = array();
            foreach ($row_range as $row) {
                $data[] = [
                    'name' => $sheet->getCell('A' . $row)->getValue(),
                    'category_id' => $sheet->getCell('B' . $row)->getValue(),
                    'style_id' => $sheet->getCell('C' . $row)->getValue(),
                    'price' => $sheet->getCell('D' . $row)->getValue(),
                ];
                $startcount++;
            }
            ProductModel::insert($data);
        } catch (Exception $e) {
            $error_code = $e->errorInfo[1];
            return back()->withErrors('Đã xảy ra sự cố khi tải lên!');
        }
        return back()->withSuccess('Great! Successfully uploaded.');
    }

    public function ExportExcel($data)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($data);
            $Excel_writer = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="ExportedData.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }

    function export_product()
    {
        $data = ProductModel::orderBy('id', 'DESC')->get();
        $data_array[] = array("Name", "Category", "Style", "Price", "Price_old", "Sold");
        foreach ($data as $data_item) {
            $data_array[] = array(
                'Name' => $data_item->name,
                'Category' => $data_item->category->name,
                'Style' => $data_item->style->name,
                'Price' => number_format($data_item->price, 0, '', ','),
                'Price_old' => number_format($data_item->old_price, 0, '', ','),
                'Sold' => $data_item->sold,
            );
        }
        $this->ExportExcel($data_array);
    }

    function export_user()
    {
        $data = User::orderBy('id', 'DESC')->where('is_admin', 0)->get();
        $data_array[] = array("Họ tên", "Email", "Phone", "DOB", "Giới tính", "Địa chỉ");
        foreach ($data as $data_item) {
            $data_array[] = array(
                'Họ tên' => $data_item->name,
                'Email' => $data_item->email,
                'Phone' => $data_item->phone,
                'DOB' => date('d-m-Y', strtotime($data_item->DOB)),
                'Giới tính' => $data_item->sex ===1?"Nam":"Nữ",
                'Địa chỉ' => $data_item->address,
            );
        }
        $this->ExportExcel($data_array);
    }

    function export_order()
    {
        $data = DB::table('tbl_order')
            ->join('users', 'users.id', '=', 'tbl_order.user_id')
            ->join('shipping_models', 'shipping_models.id', '=', 'tbl_order.shipping_id')
            ->join('tbl_payment', 'tbl_payment.payment_id', '=', 'tbl_order.payment_id')
            ->select('users.name', 'users.phone', 'shipping_models.*', 'tbl_payment.payment_option', 'tbl_payment.payment_status')
            ->get();
        $data_array[] = array("Người đặt", "Phone", "Người nhận", "Phone nhận", "Địa chỉ", "Kiểu thanh toán", "Tình trạng", "Ngày đặt", "Ghi chú");
        foreach ($data as $data_item) {
            $data_array[] = array(
                'Người đặt' => $data_item->name,
                'Phone' => $data_item->phone,
                'Người nhận' => $data_item->shipping_name,
                'Phone nhận' => $data_item->shipping_phone,
                'Địa chỉ' => $data_item->shipping_address,
                'Kiểu thanh toán' => $data_item->payment_option,
                'Tình trạng'=> $data_item->payment_status,
                'Ngày đặt' => date('d-m-Y', strtotime($data_item->created_at)),
                'Ghi chú' => $data_item->shipping_note,
            );
        }
        $this->ExportExcel($data_array);
    }
}
