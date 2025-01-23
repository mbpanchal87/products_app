<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $staticUsername = 'admin';
    private $staticPassword = 'admin';
    private function authenticate(Request $request)
    {
        // Get the Authorization header
        $authorization = $request->header('Authorization');

        // If there's no Authorization header, return false
        if (!$authorization) {
            return false;
        }

        // Basic Auth header format: "Basic base64(username:password)"
        if (substr($authorization, 0, 6) != 'Basic ') {
            return false;
        }

        // Decode the base64 encoded username and password
        $decoded = base64_decode(substr($authorization, 6));

        // Split the decoded string into username and password
        list($username, $password) = explode(':', $decoded);

        // Check if the username and password match the static ones
        return $username === $this->staticUsername && $password === $this->staticPassword;
    }
    public function index(Request $request)
    {
        if (!$this->authenticate($request)) {
            // Return 401 Unauthorized if authentication fails
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $products = Product::all();
        return response()->json(['products' => $products]);
    }

    public function search(Request $request)
    {
        if (!$this->authenticate($request)) {
            // Return 401 Unauthorized if authentication fails
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $query = $request->get('query');
        $products = Product::where('name', 'like', '%' . $query . '%')
            ->get();

        return response()->json(['products' => $products]);
    }

    public function destroy(Request $request,$id)
    {
        if (!$this->authenticate($request)) {
            // Return 401 Unauthorized if authentication fails
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}