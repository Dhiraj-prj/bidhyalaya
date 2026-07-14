<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Http\Requests\Admin\ProgramRequestForm;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Level;



    class ProgramController extends Controller
    {
        public function index() {
            // Fetch categories with the associated 'created_by' user
            $Program = Program::with('created_by')->where('is_deleted', false)->get();
            return view('admin.program.index', compact('Program'));
        }

        public function create(){
            return view('admin.program.create');
        }

        // Controller function to store the created Program
        public function store(ProgramRequestForm $request){
            $data = $request->validated();

            $Program = new Program;

            $Program->name = $data['name'];
            $Program->slug = $this->generateSlug($data['name']);;
            $Program->description = $data['description'];
            $Program->levelType = $data['levelType'];
            $Program->meta_title = $data['meta_title'];
            $Program->meta_description = $data['meta_description'];
            $Program->meta_keyword = $data['meta_keyword'];
            $Program->navbarHiddenStatus = $request->has('navbarHiddenStatus'); // This will be true if checked, false if not
            $Program->hideStatus = $request->has('hideStatus'); // Same logic applies here
            $Program->created_by = auth()->user()->id;
            $Program->save();

            // Return with a success message or redirect
            return redirect('admin/program')->with('message', 'program added successfully!');
        }

        public function edit($Program_id){
            $Program = Program::find($Program_id);
            return view('admin.program.edit',compact('Program'));
        }
        public function update(ProgramRequestForm $request, $Program_id){
            $data = $request->validated();

            $Program = Program::find($Program_id);
            $Program->name = $data['name'];
            $Program->slug = $this->generateSlug($data['name']);;
            $Program->description = $data['description'];

            $Program->meta_title = $data['meta_title'];
            $Program->meta_description = $data['meta_description'];
            $Program->meta_keyword = $data['meta_keyword'];
            $Program->navbarHiddenStatus = $request->has('navbarHiddenStatus'); // This will be true if checked, false if not
            $Program->hideStatus = $request->has('hideStatus'); // Same logic applies here
            $Program->created_by = auth()->user()->id;
            $Program->update();

            // Return with a success message or redirect
            return redirect('admin/program')->with('message', 'program Updated successfully!');
        }

        public function destroy($Program_id){
            // Find the Program by ID
            $Program = Program::find($Program_id);

            // Check if the Program exists
            if ($Program) {
                // Perform soft delete
                $Program->is_deleted = true; // or $Program->is_deleted = 1;
                $Program->save();

                // Return a success message or redirect
                return redirect('admin/program')->with('destroy_message', 'program deleted successfully!');
            }

            // If the Program does not exist
            return redirect('admin/program')->with('error', 'Program not found!');
        }

        private function generateSlug($name)
        {
            // Convert to lowercase, remove special characters, and replace spaces with hyphens
            $slug = strtolower(trim($name)); // Lowercase and trim the name
            $slug = preg_replace('/[^a-z0-9 -]/', '', $slug); // Remove special characters
            $slug = preg_replace('/\s+/', '-', $slug); // Replace spaces with dashes
            $slug = preg_replace('/-+/', '-', $slug); // Replace multiple dashes with a single one

            // Check if the slug already exists, and append a number if necessary
            $count = Program::where('slug', $slug)->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1); // Append a number to make the slug unique
            }

            return $slug;
        }

        public function getLevels($ProgramId)
        {
            // Fetch the Program using the given ProgramId
            $Program = Program::find($ProgramId);

            if (!$Program) {
                return response()->json(['error' => 'Program not found'], 404);
            }

            // Determine the levels based on the Program's levelType
            $levels = [];
            if ($Program->levelType == 1) { // If levelType is Semester
                $levels = [
                    ['id' => 1, 'name' => 'Semester I'],
                    ['id' => 2, 'name' => 'Semester II'],
                    ['id' => 3, 'name' => 'Semester III'],
                    ['id' => 4, 'name' => 'Semester IV'],
                    ['id' => 5, 'name' => 'Semester V'],
                    ['id' => 6, 'name' => 'Semester VI'],
                    ['id' => 7, 'name' => 'Semester VII'],
                    ['id' => 8, 'name' => 'Semester VIII'],
                ];
            } elseif ($Program->levelType == 2) { // If levelType is Year
                $levels = [
                    ['id' => 1, 'name' => 'Year I'],
                    ['id' => 2, 'name' => 'Year II'],
                    ['id' => 3, 'name' => 'Year III'],
                    ['id' => 4, 'name' => 'Year IV'],
                ];
            }

            return response()->json($levels);
        }




    }
