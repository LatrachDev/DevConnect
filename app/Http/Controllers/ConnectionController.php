<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as USER;
use App\Models\Connection;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    // send connection request
    public function sendRequest(User $user){

        // Check the connection
        $existingConnection = Connection::where(function($query) use ($user) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $user->id)
                      ->where('status', 'pending');
            })
            ->orWhere(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', Auth::id())
                      ->where('status', 'pending');
            })
            ->exists();

        if ($existingConnection) 
        {
            return redirect()->route('connections.index')->with('error', 'Connection request already exists.');
        }

        // Create new connection request
        $connection = Connection::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
        ]);

        return redirect()->route('connections.index')->with('success', 'Connection request sent successfully.');

    }

    // accept connection request
    public function acceptRequest(Connection $connection){

        if ($connection->receiver_id !== Auth::id() || $connection->status !== 'pending') 
        {
            return redirect()->route('connections.index')->with('error', 'Unauthorized action.');
        }

        $connection->update(['status' => 'accepted']);

        return redirect()->route('connections.index')->with('success', 'Connection request accepted.');
    }

    // reject connection
    public function rejectRequest(Connection $connection){

        if ($connection->receiver_id !== Auth::id() || $connection->status !== 'pending') 
        {
            return redirect()->route('connections.index')->with('error', 'Unauthorized or invalid action.');
        }

        $connection->delete();

        return redirect()->route('connections.index')->with('success', 'Connection request rejected.');
    }

    // remove connection
    public function removeConnection(Connection $connection){

        if (!in_array(Auth::id(), [$connection->sender_id, $connection->receiver_id])) {
            return redirect()->route('connections.index')->with('error', 'Unauthorized or invalid action.');
        }

        $connection->delete();

        return redirect()->route('connections.index')->with('success', 'Connection removed successfully.');
    }

    // pending requests
    public function getPendingRequests(){
        $pendingRequests = Connection::with(['sender', 'receiver'])
            ->where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->get();

        return response()->json([
            'success' => true,
            'pending_requests' => $pendingRequests
        ]);
    }

    // accepted connection
    public function getAcceptedConnections(){
        $connections = Connection::with(['sender', 'receiver'])
            ->where(function($query) {
                $query->where('sender_id', Auth::id())
                    ->orWhere('receiver_id', Auth::id());
            })
            ->where('status', 'accepted')
            ->get();

        return response()->json([
            'success' => true,
            'connections' => $connections
        ]);
    }

    // check the connection status
    public function checkConnectionStatus(User $user){
        $connection = Connection::where(function($query) use ($user) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $user->id);
            })
            ->orWhere(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', Auth::id());
            })
            ->first();

        $status = 'not_connected';
        if ($connection) {
            $status = $connection->status;
        }


        return response()->json([
            'success' => true,
            'status' => $status
        ]);
    }

    // get all connections : render the connections view
    public function getAllConnections()
    {
        $connections = Connection::where('sender_id', Auth::id())
        ->orWhere('receiver_id', Auth::id())
        ->paginate(10);
        return view('connections.index', compact('connections'));
    }

    public function showConnectionsPage()
    {
        $pendingRequests = Connection::with('sender')
            ->where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->get();

        $acceptedConnections = Connection::with('receiver')
            ->where(function($query) {
                $query->where('sender_id', Auth::id())
                      ->orWhere('receiver_id', Auth::id());
            })
            ->where('status', 'accepted')
            ->get();

        return view('connections.index', compact('pendingRequests', 'acceptedConnections'));
    }
}