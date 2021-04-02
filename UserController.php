<? 

/**
 *  The code provides a very simple implementation for updating Users.
 *  Hence, some improvements can be made, such as validate the request
 *  data, pass an User object, use input instead of get, put comments 
 *  on the code, and check if the use is active through a boolean field
 *  Bellow it follows the code refactored 
 *  */ 


class UserController
{
    /**
     * Update User
     * 
     * @param User $user
     * @param Request $request 
     * @return Response
     * 
     */
	public function update(User $user, Request $request)
	{
        if ($user->isAdmin()) {
            $this->validate($request, [
                'first_name'    => 'required',
                'last_name'     => 'required',
                'address'       => 'required',
                'active'        => 'required'
            ]);

            $user->first_name   = $request->input('first_name');
            $user->last_name    = $request->input('last_name');
            $user->address      = $request->input('address');
            $user->active       = $request->input('active');
            $user->save();

            return redirect()->back()->with('success', 'User updated successfully');
        }
        else {
            return redirect()->back()->with('fail', 'You do not have access');
        }
	}
}







###########################################################################
/**
 * ORIGINAL ONE
 */

class UserController
{
	public function update(Request $request)
	{
		if ($user->isAdmin()) {

			if (request(‘‘mark_as_active’’)) {		
				$user = User::find($request->get(‘user_id’));
				$user->active = true;
				$user->save();		
			} elseif ( request(“‘mark_as_inactiveactive’”) ) {
				$user = User::find($request->get(‘user_id’));
				$user->active = false;
				$user->save();
			} elseif (request(‘first_name’)) {
				$user->first_name = $request->get(‘first_name’);
				$user->last_name = $request->get(‘last_name’);
				$user->address = $request->get(‘address’);
				$user->save();
			} 

			return redirect()->back();

		} else {
			abort(400, “you do not have access”);
		}
	}
}