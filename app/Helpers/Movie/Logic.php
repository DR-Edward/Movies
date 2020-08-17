<?php
namespace App\Helpers\Movie;

use App\Movie;
use App\Helpers\Miscelaneus\ImageHandler;

class Logic {
    /**
     * The validation rules.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'publicationDate' => 'required|date_format:Y-m-d',
        'image' => 'required|image',
        'active' => 'required|boolean',
    ];

    /**
     * @param Request $request
     * 
     * @return string
     */
    public static function store($request) {
        $request->validate(Logic::$rules);

        $message_type = 'success';
        $message_text = 'Created';
        $code = 201;

        $imageData = ImageHandler::store($request->file('image'));

        try{
            $movieData = $request->all();
            $movieData['imageLink'] = $imageData['link'];
            $movie = Movie::create($movieData);
        }catch(\Exception $e){
            $code = 422;
            $message_type = 'error';
            $message_text = 'Can not be created';
        }

        return [
            'data' => $movie,
            'message_type' => $message_type,
            'message_text' => $message_text,
            'code' => $code
        ];
    }
    
    /**
     * @param  int  $id
     * 
     * @return string
     */
    public static function destroy($id) {
        $message_type = 'success';
        $message_text = 'Deleted';
        $code = 200;

        try{
            $movie = Movie::findOrFail($id);
            $movie->delete();
        }catch(\Exception $e){
            $code = 404;
            $message_type = 'error';
            $message_text = 'Can not be deleted';
        }

        return [
            'message_type' => $message_type,
            'message_text' => $message_text,
            'code' => $code
        ];
    }
    
    /**
     * @param  int  $id
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function update($request, $id){
        $request->validate(Logic::$rules);

        $message_type = 'success';
        $message_text = 'Updated';
        $code = 200;

        try{
            $movie = Movie::find($id)->update($request->all());
        }catch(\Exception $e){
            $code = 404;
            $message_type = 'error';
            $message_text = 'Can not be updated';
        }

        return [
            'message_type' => $message_type,
            'message_text' => $message_text,
            'code' => $code
        ];
    }

    /**
     * @param  int  $id
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function activator($request, $id){
        $request->validate(['active'    => 'required|boolean']);

        $message_type = 'success';
        $message_text = 'Updated';
        $code = 200;

        try{
            $movie = Movie::find($id)->update(["active" => $request->input('active')]);
        }catch(\Exception $e){
            $code = 404;
            $message_type = 'error';
            $message_text = 'Can not be updated';
        }

        return [
            'message_type' => $message_type,
            'message_text' => $message_text,
            'code' => $code
        ];
    }

    /**
     * @param  int  $id
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function update_turns($request, $id){
        $request->validate(['turns_id'    => 'required|array']);

        $message_type = 'success';
        $message_text = 'Updated';
        $code = 200;

        try{
            $movie = Movie::find($id)->turns()->sync($request->input('turns_id'));
        }catch(\Exception $e){
            $code = 404;
            $message_type = 'error';
            $message_text = 'Can not be updated';
        }

        return [
            'message_type' => $message_type,
            'message_text' => $message_text,
            'code' => $code
        ];
    }
}