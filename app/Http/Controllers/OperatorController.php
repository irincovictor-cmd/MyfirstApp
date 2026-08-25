<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index()
    {
        return view('operator', ['selectedOperator' => null]);
    }

    public function showForm($type = null)
    {
        $allowed = ['add', 'subtract', 'multiply', 'divide'];

        if ($type && !in_array($type, $allowed)) {
            abort(404);
        }

        return view('operator', ['selectedOperator' => $type]);
    }

    public function calculate(Request $request, $type)
    {
        $request->validate([
            'num1' => 'required|numeric',
            'num2' => 'required|numeric',
        ]);

        $num1 = $request->input('num1');
        $num2 = $request->input('num2');
        $result = null;

        switch ($type) {
            case 'add':
                $result = $num1 + $num2;
                break;
            case 'subtract':
                $result = $num1 - $num2;
                break;
            case 'multiply':
                $result = $num1 * $num2;
                break;
            case 'divide':
                if ($num2 == 0) {
                    return back()
                        ->withInput()
                        ->withErrors(['num2' => 'Cannot divide by zero!']);
                }
                $result = $num1 / $num2;
                break;
            default:
                abort(404);
        }

        return view('operator', [
            'result' => $result,
            'num1' => $num1,
            'num2' => $num2,
            'selectedOperator' => $type,
        ]);
    }
}
