<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    /**
     * ~ Controller ~ 
     * Master Auth Groups  
    */
    
    public function indexMasterAuthGroups() {
        $groups = DB::select("SELECT aa.*, bb.users FROM (SELECT a.id, a.group_name, GROUP_CONCAT(DISTINCT b.nama ORDER BY b.nama SEPARATOR ',') AS menus, GROUP_CONCAT(DISTINCT c.report_name ORDER BY c.report_name SEPARATOR ',') AS reports FROM (SELECT id, group_name FROM tafis_auth_groups ORDER BY group_name) a LEFT JOIN (SELECT b2.id_group, b1.nama FROM tafis_menus b1 JOIN tafis_auth b2 ON b1.id = b2.id_menu) b ON a.id = b.id_group LEFT JOIN (SELECT b.id_group, a.report_name FROM tafis_ms_reports a JOIN tafis_auth_reports b ON a.id = b.id_report) c ON a.id = c.id_group GROUP BY a.id, a.group_name) aa LEFT JOIN (SELECT id_auth_group, GROUP_CONCAT(nik ORDER BY nik SEPARATOR ',') AS users FROM tafis_auth_users GROUP BY id_auth_group) bb ON aa.id = bb.id_auth_group");
        $groups = json_decode(json_encode($groups), true);

        $menus = DB::select("SELECT a.id, a.nama, a.parent_id, b.header AS parent_name, a.tipe FROM tafis_menus a LEFT JOIN tafis_menus b ON a.parent_id = b.id where a.tipe != 'header' order by nama");
        $menus = json_decode(json_encode($menus), true);

        $reports = DB::select("SELECT id, report_name, description FROM tafis_ms_reports");
        $reports = json_decode(json_encode($reports), true);

        $users = DB::select("SELECT nik, nama, kd_branch FROM tafis_user_web ORDER BY nama");
        $users = json_decode(json_encode($users), true);
        
        return view ('admin.masterAuthGroups.index')->with([
            'groups' => $groups,
            'menus' => $menus,
            'reports' => $reports,
            'users' => $users,
        ]);
    }

    public function createMasterAuthGroups (Request $request) {
        
        $validator = Validator::make($request->all(), [
            'auth_group_name' => 'string|max:255',
            'menus' => 'string|max:10000',
            'reports' => 'string|max:10000',
        ]);

        if ($validator->fails()) {
            Alert::warning('Error', 'Check your inputs!');
            return back();
        }
        
        $menus = json_decode($request->menus, true);
        $reports = json_decode($request->reports, true);

        // Insert data
        try {
            $idGroup = DB::table('tafis_auth_groups')->insertGetId([
                'group_name' => $request->input('auth_group_name'),
                'user_id' => Session::get('nik'),
            ]);

            foreach ($menus as $menu) {
                DB::table('tafis_auth')->insert([
                    'id_group' => $idGroup,
                    'id_menu' => $menu['id'],
                ]);
            }

            foreach ($reports as $report) {
                DB::table('tafis_auth_reports')->insert([
                    'id_group' => $idGroup,
                    'id_report' => $report['id'],
                ]);
            }

            Alert::success('Success', 'Input data success!');
            return back();
        }
        catch (\Exception $e) {
            Alert::error('Error', 'Error! Check your connection!');
            return back();
        }
    }

    public function deleteMasterAuthGroups(Request $request) {

        $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $request->input('id');

        try {
            DB::beginTransaction();

            DB::table('tafis_auth')->where('id', $id)->delete();
            DB::table('tafis_auth_groups')->where('id', $id)->delete();

            DB::commit();

            Alert::success('Success', 'Delete data success!');
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting auth group', ['id' => $id, 'error' => $e->getMessage()]);
            Alert::error('Error', 'Error! Check your connection!');
        }
        return back();
    }

    public function updateUsersMasterAuthGroups(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'users' => 'string|max:10000',
        ]);

        if ($validator->fails()) {
            Alert::warning('Error', 'Check your inputs!');
            return back();
        }

        $users = json_decode($request->users, true);
        $idAuthGroup = $request->id;
        
        // Update data
        try {

            foreach ($users as $user) {
                DB::table('tafis_auth_users')->insert([
                   'id_auth_group' => $idAuthGroup, 
                   'nik' => $user['id'],
                   'user_id' => Session::get('nik'),
                ]);
            }

            Alert::success('Success', 'Input data success!');
            return back();
        }
        catch (\Exception $e) {
            Alert::error('Error', 'Error! Check your connection!');
            return back();
        }

    }

    public function updateAuthGroupMasterAuthGroups (Request $request) {
        
        $validator = Validator::make($request->all(), [
            'auth_group_name' => 'string|max:255',
            'menus' => 'string|max:10000',
            'reports' => 'string|max:10000',
        ]);

        if ($validator->fails()) {
            Alert::warning('Error', 'Check your inputs!');
            return back();
        }

        $menus = json_decode($request->menus, true);
        $reports = json_decode($request->reports, true);
        $idAuthGroup = $request->id;
        $authGroupName = $request->auth_group_name;

        // Update Data
        try {

            // Menus (delete insert) table tafis_auth (pivot menu)
            DB::table('tafis_auth')->where('id_group', $idAuthGroup)->delete();

            foreach ($menus as $menu) {
                DB::table('tafis_auth')->insert([
                    'id_group' => $idAuthGroup,
                    'id_menu' => $menu['id']
                ]);
            }

            // Reports (delete insert) table tafis_auth (pivot menu)
            DB::table('tafis_auth_reports')->where('id_group', $idAuthGroup)->delete();

            foreach ($reports as $report) {
                DB::table('tafis_auth_reports')->insert([
                    'id_group' => $idAuthGroup,
                    'id_report' => $report['id'],
                ]);
            }
            
            // Auth Group table
            DB::table('tafis_auth_groups')->where('id', $idAuthGroup)->update([
                'group_name' => $authGroupName,
                'updated_at' => DB::raw('now()'),
            ]);

            Alert::success('Success', 'Update data success!');
            return back();

        }
        catch (Exception $e) {
            Alert::error('Error', 'Error! Check your connection!');
            return back();
        }

    }

    /**
     * ~ End Controller ~
     * Master Auth Groups  
    */


    /**
     * ~ Controller ~ 
     * Master Menus  
    */

    public function indexMasterMenus() {

        $menus = DB::select("SELECT a.id, a.header, a.nama, a.url, a.parent_id, b.header AS parent_name, a.user_id, a.urutan, a.ikon, a.tipe FROM TAFIS_MENUS a LEFT JOIN TAFIS_MENUS b ON a.parent_id = b.id");
        $menus = json_decode(json_encode($menus), true);

        $parents = DB::select("SELECT id, header FROM TAFIS_MENUS where tipe = 'header' order by header");
        $parents = json_decode(json_encode($parents), true);

        return view ('admin.masterMenus.index')->with([
            'menus' => $menus,
            'parents' => $parents,
        ]);
    }


    public function createMasterMenus (Request $request) {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'header' => 'string|max:255',
            'name' => 'string|max:255',
            'url' => 'string|max:255',
            'parent_id' => 'integer',
            'order' => 'integer',
            'icon' => 'string|max:255',
            'type' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            Alert::warning('Error', 'Check your inputs!');
            return back();
        }

        // Insert data
        try {
            DB::table('tafis_menus')->insert([
                "header" => $request->input('header'),
                "nama" => $request->input('name'),
                "url" => $request->input('url'),
                "parent_id" => $request->input('parent_id'),
                "user_id" => Session::get('nik'),
                "urutan" => $request->input('order'),
                "ikon" => $request->input('icon'),
                "tipe" => $request->input('type'),

            ]);

            Alert::success('Success', 'Input data success!');
            return back();
        }
        catch (\Exception $e) {
            Alert::error('Error','Error! Check your connection!');
            return back();
        }
    }


    public function updateMasterMenus (Request $request) {
        $validator = Validator::make($request->all(), [
            'header' => 'string|max:255',
            'name' => 'string|max:255',
            'url' => 'string|max:255',
            'parent_id' => 'integer',
            'order' => 'integer',
            'icon' => 'string|max:255',
            'type' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            Alert::warning('Error', 'Check your inputs!');
            return back();
        }

        // update data
        try {
            DB::table('tafis_menus')->where('id', $request->id)->update([
                "header" => $request->input('header'),
                "nama" => $request->input('name'),
                "url" => $request->input('url'),
                "parent_id" => $request->input('parent_id'),
                // "user_id" => Session::get('nik'),
                "urutan" => $request->input('order'),
                "ikon" => $request->input('icon'),
                "tipe" => $request->input('type'),
                "updated_at" => DB::raw('now()'),
            ]);

            Alert::success('Success', 'Update data success!');
            return back();
        }
        catch (\Exception $e) {
            Alert::error('Error', 'Error! Check your connection!');
            return back();
        }
    }


    public function deleteMasterMenus (Request $request) {

        $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $request->id;

        // Delete Data
        try {
            DB::beginTransaction();
            DB::table('tafis_menus')->where(['id' => $id])->delete();
            DB::commit();

            Alert::success('Success', 'Delete data success!');
            
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting menu', ['id' => $id, 'error' => $e->getMessage()]);
            Alert::error('Error','Error! Check your connection!');
        }

        return back();
    }

    /**
     * ~ End Controller ~
     * Master Auth Groups  
    */


    /**
     * ~ Controller ~ 
     * Master Menus  
    */

    public function indexMasterReports() {
        $reports = DB::select("SELECT id, report_name, description, connection, query FROM tafis_ms_reports order by created_at desc");
        $reports = json_decode(json_encode($reports), true);

        return view ('admin.masterReports.index')->with([
            'reports' => $reports,
        ]);
    }

    public function createMasterReports(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'report_name' => 'string|max:255',
            'description' => 'string|max:1000',
            'connection' => 'string|max:255',
            'query' => 'string|max:65536',
        ]);

        if ($validator->fails()) {
            Alert::warning('Error', 'Check your inputs!');
            return back();
        }

        // Insert data
        try {
            DB::table('tafis_ms_reports')->insert([
                'report_name' => $request->input('report_name'),
                'description' => $request->input('description'),
                'connection' => $request->input('connection'),
                'query' => $request->input('query'),
                'user_id' => Session::get('nik'),
            ]);

            Alert::success('Success', 'Input data success!');
        }
        catch (\Exception $e) {
            Alert::error('Error','Error! Check your connection!');
        }

        return back();
    }

    public function updateMasterReports(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'integer',
            'report_name' => 'string|max:255',
            'description' => 'string|max:1000',
            'connection' => 'string|max:255',
            'query' => 'string|max:65536',
        ]);

        if ($validator->fails()) {
            Alert::warning('Error', 'Check your inputs!');
            return back();
        }

        try {
            DB::table('tafis_ms_reports')->where('id', $request->input('id'))->update([
                'report_name' => $request->input('report_name'),
                'description' => $request->input('description'),
                'connection' => $request->input('connection'),
                'query' => $request->input('query'),
                'updated_at' => DB::raw('now()'),
            ]);

            Alert::success('Success', 'Update data success!');
        }
        catch (\Exception $e) {
            Alert::error('Error', 'Error! Check your connection!');
        }

        return back();
    }

    public function deleteMasterReports(Request $request) {
        $request->validate([
            'id' => 'required|integer',
        ]);
        
        $id = $request->input('id');

        // Delete Data
        try {
            DB::beginTransaction();
            DB::table('tafis_ms_reports')->where(['id' => $id])->delete();
            DB::commit();

            Alert::success('Success', 'Delete data success!');
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting menu', ['id' => $id, 'error' => $e->getMessage()]);
            Alert::error('Error', 'Error! Check your connection!');
        }

        return back();

    }

    /**
     * ~ End Controller ~
     * Master Auth Groups  
    */


}