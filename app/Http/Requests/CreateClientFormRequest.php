<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateClientFormRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		 $rules = [
		             'name' => 'required',
		             'location_id' => 'required',
		             'service_type' => 'required',
		             'core_type' => 'required',

		           ];

		 foreach($this->request->get('connection_id') as $key => $val)
		  {
		       $rules['connection_id.'.$key] = 'required';
		       $rules['connection_core_id1.'.$key] = 'required';
		       $rules['connection_core_id2.'.$key] = 'sharad:'.$this->request->get('core_type');

		  }

		  return $rules;

	}

	public function response(array $error)
    {
        return \Response::json($error,400);

    }

}
