<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Models\Categorie;

use App\Models\Product;
use App\Models\Reservation;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin'); // Voeg een custom 'admin' middleware toe om te controleren of de gebruiker een admin is
    }

    public function index()
    {
        $data = Reservation::paginate(10);
        return view('admin.index', compact('data'));
    }

    public function categorie_page()
    {
        $data = Categorie::paginate(10);
        return view('admin.categorie', compact('data'));
    }

    public function add_category(Request $request)
    {
        $data = new Categorie;
        $data->cat_title = $request->category;
        $data->save();
        return redirect()->back()->with('message', 'Category Added Successfully');
    }

    public function cat_delete($id)
    {
        $data = Categorie::find($id);
        $data->delete();
        return redirect()->back()->with('message', 'Category Deleted Successfully');
    }

    public function cat_edit($id)
    {
        $data = Categorie::find($id);
        return view('admin.edit_category', compact('data'));
    }

    public function update_category(Request $request, $id)
    {
        $data = Categorie::find($id);
        $data->cat_title = $request->cat_name;
        $data->save();
        return redirect('/categorie_page')->with('message', 'Category Updated Successfully');
    }

    public function add_product()
    {
        $data = Categorie::all();

        return view('admin.add_product', compact('data'));
    }

    public function store_product(Request $request)
    {
        $data = new Product;
        $data->Merk = $request->product_merk;
        $data->title = $request->product_title;
        if ($request->product_quantity > 1) {
            $data->Quantity = $request->product_quantity;
        } else {
            $data->Quantity = 1;
        }
        $data->category_id = $request->product_category;
        $data->description = $request->product_description;
        $product_image = $request->product_image;

        if ($product_image) {
            $product_image_name = time() . '.' . $product_image->getClientOriginalExtension();
            $request->product_image->move('producten_images', $product_image_name);
            $data->product_img = $product_image_name;
        }


        $data->save();
        return redirect()->back()->with('message', 'Product Added Successfully');
    }

    public function show_product()
    {
        $products = Product::all();
        return view('admin.show_product', compact('products'));
    }

    public function product_delete($id)
    {
        $data = Product::find($id);
        $data->delete();
        return redirect()->back()->with('message', 'Product Deleted Successfully');
    }

    public function update_product($id)
    {
        $data = Product::find($id);
        $category = Categorie::all();

        return view('admin.update_product', compact('data', 'category'));
    }

    public function update_product1(Request $request, $id)
    {
        $data = Product::find($id);
        $data->Merk = $request->product_merk;
        $data->title = $request->product_title;
        $data->Quantity = $request->product_quantity;
        $data->category_id = $request->product_category;
        $data->description = $request->product_description;
        $product_image = $request->product_image;

        if ($product_image) {
            $product_image_name = time() . '.' . $product_image->getClientOriginalExtension();
            $request->product_image->move('producten_images', $product_image_name);
            $data->product_img = $product_image_name;
        }

        $data->save();
        return redirect('/show_product');
    }

    public function approve_product($id)
    {
        $data = Reservation::find($id);

        if ($data->status == 'approved') {
            return redirect()->back()->with('message', 'Product Already Approved');
        } else {
            $productid = $data->product_id;
            $product = Product::find($productid);
            $product->Quantity = $product->Quantity - 1;
            $product->save();
            $data->status = 'approved';
            $data->save();
            return redirect()->back()->with('message', 'Product Approved Successfully');
        }
    }

    public function rejected_product($id)
    {
        $deleted = DB::table('Reservations')->where('id', $id)->delete();

        if ($deleted)
            return redirect()->back()->with('message', 'Product Rejected Successfully');
        else
            return redirect()->back()->with('error', 'Product not found');
    }

    public function returned_product($id)
    {
        $data = Reservation::find($id);

        if ($data->status == 'returned') {
            return redirect()->back()->with('message', 'Product Already Returned');
        } else {
            $productid = $data->product_id;
            $product = Product::find($productid);
            $product->Quantity = $product->Quantity + 1;
            $product->save();

            DB::table('Reservations')->where('id', $id)->delete();

            return redirect()->back()->with('message', 'Product Returned Successfully');
        }
    }

    public function show_user()
    {
        $data = User::all();
        return view('admin.show_user', compact('data'));
    }

    public function blacklist($id)
    {
        $data = User::find($id);
        $data->blacklist = 1;
        $data->save();
        return redirect()->back()->with('message', 'User Blacklisted Successfully');
    }

    public function unblacklist($id)
    {
        $data = User::find($id);
        $data->blacklist = 0;
        $data->save();
        return redirect()->back()->with('message', 'User Unblacklisted Successfully');
    }

    public function show_blacklist()
    {
        $data = User::where('blacklist', 1)->get();
        return view('admin.show_blacklist', compact('data'));
    }
}
