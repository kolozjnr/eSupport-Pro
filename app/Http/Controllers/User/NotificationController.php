<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{


public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(20);
        
        return view('notifications.index', compact('notifications'));
    }
    
    public function markAsRead(DatabaseNotification $notification)
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->notifiable_id !== auth()->id()) {
            abort(403);
        }
        
        $notification->markAsRead();
        
        // If there's a URL to redirect to in the notification data
        if (isset($notification->data['url'])) {
            return redirect($notification->data['url']);
        }
        
        return back()->with('success', 'Notification marked as read');
    }
    
    public function markAllAsRead(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();
        
        return back()->with('success', 'All notifications marked as read');
    }













    //alpine js route
//     public function indexal(Request $request)
//     {
//         $user = auth()->user();

//         return response()->json([
//             'status' => true,
//             'message' => 'Notifications fetched successfully',
//             'data' => [
//                 'unread' => $user->unreadNotifications,
//                 'read' => $user->readNotifications,
//             ]
//         ]);
//     }

//     public function markAllAsRead(Request $request)
// {
//     $user = auth()->user();
    
//     $user->unreadNotifications->markAsRead();
    
//     return response()->json([
//         'status' => true,
//         'message' => 'All notifications marked as read'
//     ]);
// }

//     public function show($id)
//     {
//         $notification = auth()->user()->notifications()->findOrFail($id);
        
//         return response()->json([
//             'status' => true,
//             'notification' => $notification
//         ]);
//     }

//     public function viewNotification($id)
//     {
//         $user = auth()->user();

//         $notification = $user->notifications()->where('id', $id)->firstOrFail();

//         // Mark as read if not already
//         if (is_null($notification->read_at)) {
//             $notification->markAsRead();
//         }

//         return response()->json([
//             'status' => true,
//             'message' => 'Notification retrieved successfully',
//             'data' => $notification
//         ]);
//     }
}
