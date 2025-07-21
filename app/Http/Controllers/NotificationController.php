<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use finfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Services\FirebaseNotificationService;

class NotificationController extends Controller
{
    public $firebaseNotificationService;
    public function __construct(FirebaseNotificationService $firebaseNotificationService) {
        $this->firebaseNotificationService = $firebaseNotificationService;
    }

    public function sendNotification(Request $request)
    {
        try {
            $id = $request->query('id');
            $notification = DB::table('tbl_notification')->where('nid', $id)->first();
            
            if (!$notification) {
                return redirect('notification')->with('error', 'Notification not found.');
            }

            $token = "fBt02IFnREyjxWQVkfh3VW:APA91bFgW56drB5OoN5RDfNp13bGJPlyQGP7ls4ZY_Ts0WlJZYgcHqU72yklCyoZSOloW6-hT_DMTK8ECjoBjYPfTuLXuKf5bSOejc1Vo9ibZqpgULVjmMM";

            $data = [
                "message" => [
                    // "topic"=>"your_topic_name",
                    "token" => "",
                    "data" => [
                        "title" => $notification->title,
                        "body" => $notification->desc,
                    ],
                    "notification" => [
                        "title" => $notification->title,
                        "body" => $notification->desc,
                    ]
                ],
            ];

            // return response()->json($data);

            $response = $this->firebaseNotificationService->sendNotification($token, $notification->title, $notification->desc);

            if ($response['status']) {
                return redirect()->route('notification.index')
                                ->with('success', 'Notification sent successfully.');
            } else {
                
                return redirect()->route('notification.index')
                                ->with('error', 'Something went wrong: ');
            }

        } catch (Exception $e) {
            return redirect()->route('notification.index')
                ->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    public function create(){
        return view('notification.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'  => 'required|string|max:255',
            'desc'   => 'required|string',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:show,hide',
        ]);

        if ($request->hasFile('image')) {
            $filename = 'notification/' . rand(99999, 9999999) . time() . '.' . $request->image->extension();
            $request->image->move(public_path('notification/'), $filename);
            $validated['image'] = $filename;
        }

        Notification::create($validated);

        return redirect()->route('notification.index')->with('success', 'Notification created successfully!');
    }
    public function index() {
        $notifications = Notification::orderBy('nid', 'asc')->get();
        return view('notification.index', compact('notifications'));
    }
    public function edit($id){
        $notification = Notification::where('nid',$id)->first();
        // dd($notification);
        return view('notification.edit',compact('notification'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'  => 'required|string|max:255',
            'desc'   => 'required|string',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:show,hide',
        ]);

        $notification = Notification::findOrFail($id);

        if ($request->hasFile('image')) {
            
            if ($notification->image && file_exists(public_path($notification->image))) {
                unlink(public_path($notification->image));
            }

            $filename = 'notification/' . rand(99999, 9999999) . time() . '.' . $request->image->extension();
            $request->image->move(public_path('notification/'), $filename);
            $validated['image'] = $filename;
        }

        $notification->update($validated);

        return redirect()->route('notification.index')->with('success', 'Notification updated successfully!');
    }

}