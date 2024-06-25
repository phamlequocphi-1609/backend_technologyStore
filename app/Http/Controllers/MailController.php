<?php

namespace App\Http\Controllers;

use App\Mail\MailNotify;
use App\Mail\OrderMail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
 
    private function generateOrderCode()
    {
        $date = Carbon::now()->format('ymd'); 
        $random = strtoupper(substr(bin2hex(random_bytes(4)), 0, 10)); 

        return $date . $random;
    }
    public function send(Request $request){
        $ordercode = $this->generateOrderCode();
        $orderdate = Carbon::now()->format('d-m-Y');
        $details = [
            'subject' => 'Invoice Information',
            'body' => [
                'name' => $request->input('name'),
                'company' => $request->input('company'),
                'country' => $request->input('country'),
                'address' => $request->input('address'),
                'provincecity' => $request->input('provincecity'),
                'phone' => $request->input('phone'),
                'note' => $request->input('note'),
                'cart'=>$request->input('cart'),
                'total'=>$request->input('total'),
                'ordercode' => $ordercode,
                'orderdate'=>$orderdate,
            ]
        ];

        try {
            Mail::to($request->input('email'))->send(new OrderMail($details));
            return response()->json(['message' => 'Order paid successfully',
                'orderCode'=>$ordercode,
                'orderdate'=> $orderdate
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error']);
        }
    }
}