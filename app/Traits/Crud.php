<?php
namespace App\Traits;
use Illuminate\Contracts\Validation\Rule\NotPresent;
use App\Helpers\Miscelaneus\ImageHandler;

trait Crud {
    /**
     * Display a listing of the resource.
     *
     * @param  array  $relationships
     * @return array
     */
    public static function index_default($relationships = []) {
        $resources = self::with($relationships)->orderBy('id', 'desc')->paginate(10);
        return $resources;
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static function store_with_file($request) {
        $request->validate(self::$rules);
        
        $resource = null;
        $message_type = 'success';
        $message_text = 'Created successfully';
        $code = 201;

        $imageData = ImageHandler::store($request->file('image'));

        try{
            $data = $request->all();
            $data['imageLink'] = $imageData['link'];
            $resource = self::create($data);
        }catch(\Exception $e){
            $resource = $e;
            $message_type = 'error';
            $message_text = 'Can not be created';
            $code = 422;
        }

        return [
            'data' => $resource,
            'message_type' => $message_type,
            'message_text' => $message_text,
            'code' => $code
        ];
    }

    // TODO - NEEDS REFACTORING: we need a service provider for file storing and also unificate both functions for storage!

    /**
     * Store a newly created resource in storage.
     * 
     * @param  int  $id
     * @return array
     */
    public static function store_default($request) {
        $request->validate(self::$rules);

        $resource = null;
        $message_type = 'success';
        $message_text = 'Created successfully';
        $code = 200;

        try{
            $resource = self::create($request->all());
        }catch(\Exception $e){
            $resource = $e;
            $message_type = 'error';
            $message_text = 'Can not be created';
            $code = 404;
        }

        return [
            'data' => $resource,
            'message_type' => $message_type,
            'message_text' => $message_text,
            'code' => $code
        ];
    }

    /**
     * Display the specified resource.
     * 
     * @param  int  $id
     * @return array
     */
    public static function show_default($id, $relationships = []) {
        $message_type = 'success';
        $message_text = 'Found it.';
        $code = 200;

        try{
            $resource = self::with($relationships)->findOrFail($id);
        }catch(\Exception $e){
            $resource = $e;
            $message_type = 'error';
            $message_text = 'Can not be found';
            $code = 404;
        }

        return [
            'data' => $resource,
            'message_type' => $message_type,
            'message_text' => $message_text,
            'code' => $code
        ];
    }

    /**
     * Update the specified resource in storage.
     * it can be one field or more. This is controlled by the rules implemented in each case
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $rules
     * @param  int  $id
     * @return array
     */
    public static function update_default($request, $rules = [], $id){
        $request->validate($rules);

        $resource = null;
        $message_type = 'success';
        $message_text = 'Updated';
        $code = 200;

        try{
            $resource = self::findOrFail($id)->update($request->all());
        }catch(\Exception $e){
            $resource = $e;
            $message_type = 'error';
            $message_text = 'Can not be updated';
            $code = 404;
        }

        return [
            'data' => $resource,
            'message_type' => $message_type,
            'message_text' => $message_text,
            'code' => $code
        ];
    }

    /**
     * Update the specified resource in storage.
     * it can be one field or more. This is controlled by the rules implemented in each case
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $rules
     * @param  int  $id
     * @return array
     */
    public static function update_with_file($request, $rules = [], $id){
        $request->validate($rules);

        $resource = null;
        $message_type = 'success';
        $message_text = 'Updated';
        $code = 200;

        try{
            $data = $request->all();
            $resource = self::findOrFail($id);

            if( $request->file('image') ){
                $imageData = ImageHandler::store($request->file('image'));
                $data['imageLink'] = $imageData['link'];
            }

            $resource->update($data);
        }catch(\Exception $e){
            $resource = $e;
            $message_type = 'error';
            $message_text = 'Can not be updated';
            $code = 404;
        }

        return [
            'data' => $resource,
            'message_type' => $message_type,
            'message_text' => $message_text,
            'code' => $code
        ];
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  int  $id
     * @return array
     */
    public static function destroy($id) {
        $resource = null;
        $message_type = 'success';
        $message_text = 'Deleted';
        $code = 200;

        try{
            $resource = self::findOrFail($id);
            $resource->delete();
        }catch(\Exception $e){
            $resource = $e;
            $message_type = 'error';
            $message_text = 'Can not be deleted';
            $code = 404;
        }

        return [
            'data' => $resource,
            'message_type' => $message_type,
            'message_text' => $message_text,
            'code' => $code
        ];
    }


    // RELATIONSHIPS

    /**
     * $relation_name must be a valid relationship
     * $field_name must be a valid request input name
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  string  $relation_name
     * @param  string  $field_name
     * @return array
     */
    public static function update_many_to_many($request, $id, $relation_name = '', $field_name = 'id_array'){
        $request->validate([
            $field_name   => 'required|array',
            $field_name.'.*' => 'integer',
        ]);

        $resource = null;
        $message_type = 'success';
        $message_text = 'Updated';
        $code = 200;

        try{
            $resource = self::findOrFail($id)->$relation_name()->sync($request->input($field_name));
        }catch(\Exception $e){
            $resource = $e;
            $code = 404;
            $message_type = 'error';
            $message_text = 'Can not be updated';
        }

        return [
            'data' => $resource,
            'message_type' => $message_type,
            'message_text' => $message_text,
            'code' => $code
        ];
    }
}