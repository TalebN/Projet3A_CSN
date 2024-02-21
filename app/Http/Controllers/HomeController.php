<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

use Session;
use Stripe;


class HomeController extends Controller
{
   public function redirect(){

$usertype=Auth::user()->usertype;
if($usertype=='1'){
   $total_product=product::all()->count();
   $total_order=order::all()->count();
   $total_user=user::all()->count();
   $order=order::all();
   $total_revenue=0;

   foreach($order as $order)
   {
      $total_revenue=$total_revenue + $order->price;

   }
   $total_delivered=order::where('delivery_status','=','delivered')->get()->count();
   $total_processing=order::where('delivery_status','=','processing')->get()->count();


    return view('admin.home',compact('total_product','total_order','total_user','total_revenue','total_delivered','total_processing'));
   }
else
   { 
      $product=Product::paginate(10);
      return view('home.userpage',compact('product'));
   }


   }


   public function index(){
      $product=Product::paginate(10);
      return view('home.userpage',compact('product'));
      
   }

   ///////////////////
   public function registerB(){
      return view('home.registerBeginer');
      
   }

   public function customRegister(Request $request)
    {
      $product=Product::paginate(10);
     
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string'
        ]);

        // Création de l'utilisateur sans chiffrement du mot de passe
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Stockage du mot de passe en clair (non recommandé)
        ]);
        return view('home.userpage',compact('product'));
    }


   public function loginB(){
      return view('home.loginBeginer');
      
   }
   public function customLogind(Request $request)
   {
       // Validation des données entrantes
       $request->validate([
           'email' => 'required|email',
           'password' => 'required',
       ]);

       // Vérification des identifiants sans hasher le mot de passe
       $user = User::where('email', $request->email)
                   ->where('password', $request->password) // À NE PAS FAIRE dans une application réelle
                   ->first();

       if ($user) {
           // Si les identifiants correspondent, enregistrer les infos utilisateur en session
           Session::put('user', $user->toArray());
           $product=Product::paginate(10);
           // Rediriger vers une page (par ex. tableau de bord)
           return view('home.userpage',compact('product'));
       } else {
           // Si les identifiants ne correspondent pas, retourner avec une erreur
           return back()->withErrors([
               'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
           ]);
       }
   }

   public function customLogin(Request $request)
{
    // Validation des données entrantes
    $request->validate([
        'email' => 'required|email'
    ]);

    // Récupération de l'utilisateur par email
    $user = User::where('email', $request->email)->first();

    $email = $request->input('email');
    $password = $request->input('password');

    // Construction et exécution d'une requête SQL non sécurisée
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $user1 = DB::select(DB::raw($sql));
    if ($user1) {
        $product=Product::paginate(10);
      //   dd($user,$user->password,$request->password);
        Auth::login($user);
      // /  dd($user);
        return view('home.userpage',compact('product'));
    } else {
        // Les identifiants ne correspondent pas, retour avec une erreur
        return back()->withErrors([
            'message' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ]);
    }
   }
   //////////////

   public function product_details($id)
   {
      $product=product::find($id);
      return view('home.product_details',compact('product'));
      
   }

   public function add_cart(Request $request,$id)
   {
      if(Auth::id())
      {
         $user=Auth::user();
         $product=product::find($id);
         $cart=new cart;
         $cart->name=$user->name;
         $cart->email=$user->email;
         $cart->phone=$user->phone;
         $cart->address=$user->address;
         $cart->user_id=$user->id;
         $cart->Product_title=$product->title;
         if($product->discount_price!=null)
         {
            $cart->price=$product->discount_price * $request->quantity;
         }
         else
         {
            $cart->price=$product->price* $request->quantity ;
         }
         $cart->image=$product->image;
         $cart->Product_id=$product->id;
         $cart->quantity=$request->quantity;
         $cart->save();
         return redirect()->back();
     
      }
      else
      {
         return redirect('login');
      }
   }


   public function show_cart()
   {
      if(Auth::id())
      {
         $id=Auth::user()->id;
         $cart=cart::where('user_id','=',$id)->get();
         return view('home.showcart',compact('cart'));
      }
      
      else
      {
         return redirect('login');
      }
      
   }
   public function remove_cart($id)
   {
      $cart=cart::find($id);
      $cart->delete();
      return redirect()->back();
      
   }

   public function cash_order()
   {
      $user=Auth::user();
      $userid=$user->id;
      $data=cart::where('user_id','=',$userid)->get();
      foreach($data as $data)
      {
         $order=new order;
         $order->name=$data->name;
         $order->email=$data->email;
         $order->phone=$data->phone;
         $order->address=$data->address;
         $order->user_id=$data->user_id;
         $order->product_title=$data->product_title;
         $order->price=$data->price;
         $order->quantity=$data->quantity;
         $order->image=$data->image;
         $order->product_id=$data->Product_id;
         $order->payment_status='Paid';
         $order->delivery_status='processing';
         $order->save();
         $cart_id=$data->id;
         $cart=cart::find($cart_id);
         $cart->delete();

      }
      return redirect()->back()->with('message','We have Received your Order.We Will connect with you soon...');

   }

   public function stripe($totalprice)
   {
      return view('home.stripe',compact('totalprice'));
   }
   
   public function stripePost(Request $request,$totalprice)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => $totalprice * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thanks for payment." 
        ]);
      
        Session::flash('success', 'Payment successful!');
              
        return back();
    }


    public function product_search(Request $request)
    {
      
      $search_text=$request->search;
      $product=product::where('title','LIKE',"%$search_text%")->orWhere('category','LIKE',"%$search_text%")->paginate(10);
      return view('home.userpage',compact('product'));

    }

    // XSS
    public function contact()
    {
       return view('home.testXss');
       
    }

    public function soumettreFormulaire(Request $request)
{
    $message = $request->input('message');
    // Ici, vous pouvez faire quelque chose avec le message, comme le sauvegarder ou le valider.
    return view('home.resultXss', compact('message'));
}


}
