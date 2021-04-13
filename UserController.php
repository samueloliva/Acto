<? 

/**
 * A way of creating short methods for UserController would be 
 * to set routes and using oauth and middleware. So, just admin 
 * users have access to these methods (update and changeStatus).
 * 
 * The validation can be done through the class UserRegisterRequest
 * instead of doing in the UserController.
 * 
 * And I would break the update details and change status in
 * two methods, one called update and the other changeStatus.
 * This would turn the methods shorter, clearer and more readable. 
 */

class UserController
{   
    /**
     * Update User details
     * 
     * @param $id
     * @param UserRegisterRequest $request 
     * @return Response
     * 
     */
    public function update($id, UserRegisterRequest $request ) 
    {
        $user = User::find($id);
        $user->first_name   = $request->input('first_name');
        $user->last_name    = $request->input('last_name');
        $user->address      = $request->input('address');
        $user->save();
        return redirect()->back()->with('success', 'User updated successfully');
    }

    /**
     * Update User status
     * 
     * @param $id
     * @param Request $request 
     * @return Response
     * 
     */
    public function changeStatus($id, Request $request) 
    {
        $user = User::find($id);
        $user->active = $request->input('active');
        $user->save();
        return redirect()->back()->with('success', 'User updated successfully');
    }
}
