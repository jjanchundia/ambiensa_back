<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use DB;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employee = Employee::select("employees.*",
        "departments.name as deparment")
        ->join("departments", "departments.id", "=", "employees.department_id")
        ->where("employees.status", 1)
        ->paginate(10);
        return response()->json($employee);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // "name", "address", "email", "phone", "department_id", "status
        $rules = [
            "name" => "required|string|min:1|max:100",
            "address" => "required|string|min:1|max:100",
            "email" => "required|email|max:60",
            "phone" => "required|max:100",
            "department_id" => "required|numeric"
        ];
        $validator = \Validator::make($request->input(), $rules);
        if($validator->fails()){
            return response()->json([
                "status" => false,
                "errors" => $validator->errors()->all()
            ], 400);
        }

        // Crear una nueva instancia del modelo Employee y asignar valores
        $employee = new Employee($request->all());

        // Asignar un valor predeterminado para la columna status
        $employee->status = 1;

        // Guardar el nuevo registro en la base de datos
        $employee->save();

        return response()->json([
            "status" => true,
            "message" => "Empleado creado correctamente!"
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return response()->json([
            "status" => true,
            "data" => $employee], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $rules = [
            "name" => "required|string|min:1|max:100",
            "address" => "required|string|min:1|max:100",
            "email" => "required|email|max:60",
            "phone" => "required|max:100",
            "department_id" => "required|numeric"
        ];
        $validator = \Validator::make($request->input(), $rules);
        if($validator->fails()){
            return response()->json([
                "status" => false,
                "errors" => $validator->errors()->all()
            ], 400);
        }

        $employee->update($request->input());
        return response()->json([
            "status" => true,
            "message" => "Empleado actualizado correctamente!"
        ], 200);//
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        // Actualizar el campo 'status' a 0
        $employee->update(['status' => 0]);

        return response()->json([
            "status" => true,
            "message" => "Empleado eliminado correctamente!"
        ], 200);
    }

    public function employeesByDepartment(){
        $employees = Employee::select(DB::raw("count(employees.id) as count",
        "departments.name"))
        ->join("departments", "departments.id", "=", "employees.department_id")
        ->groupBy("departments.name")->get();
        return response()->json($employees);
    }

    public function all(){
        $employee = Employee::select("employees.*",
        "departments.name as deparment")
        ->join("departments", "departments.id", "=", "employees.department_id")
        ->where("employees.status", 1)
        ->get();
        return response()->json($employee);
    }
}
