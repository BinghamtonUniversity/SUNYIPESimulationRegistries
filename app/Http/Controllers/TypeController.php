<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Models\Type;
use App\Models\Value;

class TypeController extends Controller
{
    public function index() {
        return Type::with('values')->get();
    }

    public function store(StoreTypeRequest $request) {
        $type = new Type($request->all());
        $type->save();
        return $type;
    }

    public function show(Type $type) {
        return $type;
    }

    public function update(UpdateTypeRequest $request, Type $type) {
        $type->update($request->all());
        return $type;
    }

    public function destroy(Type $type) {
        $type->delete();
        return 1;
    }

    // Type Values
    public function value_index(Type $type) {
        return Value::where('type_id',$type->id)->get();
    }

    public function value_store(StoreValueRequest $request, Type $type) {
        $value = new Value($request->all());
        $value->type_id = $type->id;
        $value->save();
        return $value;
    }

    public function value_show(Type $type, Value $value) {
        if ($value->type_id !== $type->id) {
            abort("The specified value does not belong to the specified type!");
        }
        return $value;
    }

    public function value_update(UpdateValueRequest $request, Type $type, Value $value) {
        if ($value->type_id !== $type->id) {
            abort("The specified value does not belong to the specified type!");
        }
        $value->update($request->all());
        return $type;
    }

    public function value_destroy(Type $type, Value $value) {
        $type->delete();
        return 1;
    }

}
