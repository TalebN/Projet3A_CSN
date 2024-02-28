<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\URL;
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
      $product = Product::paginate(10);
      $url = request()->fullUrl(); 
      $mode = null;
  
      if (strpos($url, 'secureMode') !== false) {
          $mode = 'secure';}
      else if(strpos($url, 'vulnerableMode') !== false){
         $mode = 'insecure';
      }
    
      return view('home.userpage', compact('product', 'mode'));
  }
   ///////////////////  choix du mode d'utilisation : mode securisé vs non securisé
   public function choix(){
      $product=Product::paginate(10);
      return view('home.choix');

   }
   ///////////////////

   public function registerSec(){
      return view('home.registerdefense');

   }

   public function registerNotSec(){
      return view('home.registerBeginer');

   }

   public function customRegisterSec(Request $request)
{
    $product = Product::paginate(10);
    $mode = 'secure';
    $validator = $request->validate([
        'email' => 'required|email|unique:users,email',
        'password' => [
            'required',
            'string',
            Password::min(8) // Au moins 8 caractères
                ->mixedCase() // Au moins une lettre majuscule et une lettre minuscule
                ->letters() // Au moins une lettre
                ->numbers() // Au moins un chiffre
                ->uncompromised(), // Vérifier que le mot de passe n'est pas compromis (facultatif)
        ],
    ], [
        'email.required' => 'Le champ email est requis.',
        'email.email' => 'Veuillez entrer une adresse email valide.',
        'email.unique' => 'Cette adresse email est déjà utilisée.',
        'password.required' => 'Le champ mot de passe est requis.',
        'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
        'password.min' => 'Le mot de passe doit avoir au moins 8 caractères et contenir au moins une lettre majuscule, une lettre minuscule et un chiffre.',
    ]);

    if ($validator) {
        // Création de l'utilisateur avec hachage du mot de passe
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hashage du mot de passe
        ]);

        // Retourner la vue 'home.userpage' avec les données de produit
        return view('home.userpage', compact('product','mode'));
    } else {
        return redirect()->back()->withErrors(['password' => 'Attention: le mot de passe ne répond pas aux exigences.']);
    }
}

public function customRegisterNotSec(Request $request)
   {
   $product=Product::paginate(10);
   $mode = 'insecure';

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
      return view('home.userpage',compact('product', 'mode'));
   }


   public function loginSec(){
      return view('home.logindefense');

   }

   public function loginNotSec(){
      return view('home.loginBeginer');

   }

   public function customloginNotSec(Request $request)
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
        Auth::login($user);
        if ($user->usertype =='1'){
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
      elseif ($user->usertype =='0'){
         $product=Product::paginate(10);
         return view('home.userpage',compact('product'));
        }
    } else {
        // Les identifiants ne correspondent pas, retour avec une erreur
        return back()->withErrors([
            'message' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ]);
    }

       
   }

   public function customLogin(Request $request)
   {
       // Validation des données entrantes
       $request->validate([
           'email' => 'required|email',
           'password' => 'required',
       ]);

       // Récupération de l'utilisateur par email
       $user = User::where('email', $request->email)->first();


       if ($user) {
           // Vérification du mot de passe à l'aide de la méthode check
           if (Hash::check($request->password, $user->password)) {
               // Authentification réussie
               Auth::login($user);
               if($user->usertype =='1'){
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
            elseif ($user->usertype =='0'){
               $product=Product::paginate(10);
               return view('home.userpage',compact('product'));
            }

           } else {
               // Journalisation des tentatives de connexion infructueuses
               Log::warning('Tentative de connexion infructueuse pour l\'utilisateur avec l\'email : ' . $request->email);
           }
       } else {
           // Journalisation des tentatives de connexion avec un email non enregistré
           Log::warning('Tentative de connexion avec un email non enregistré : ' . $request->email);
       }

       // Les identifiants ne correspondent pas, retour avec une erreur
       return back()->withErrors([
           'message' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
       ]);
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
