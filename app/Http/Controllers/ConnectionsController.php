<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Connection;
use Illuminate\Http\Request;

class ConnectionsController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        
        $pendingRequests = Connection::where('receiver_id', auth()->id())
            ->where('status', 'pending')
            ->with('sender')
            ->get();

        // Get all accepted connections
        $acceptedConnections = Connection::where(function($query) {
                $query->where(function($q) {
                    $q->where('sender_id', auth()->id())
                      ->orWhere('receiver_id', auth()->id());
                });
            })
            ->where('status', 'accepted')
            ->with(['sender', 'receiver'])
            ->get()
            ->map(function ($connection) {
                // Get the other user in the connection
                return $connection->sender_id === auth()->id() 
                    ? $connection->receiver 
                    : $connection->sender;
            });

        return view('connections.index', compact('users', 'pendingRequests', 'acceptedConnections'));
    }

    public function request(User $user)
    {
        // Check if connection already exists
        $existingConnection = Connection::where(function($query) use ($user) {
                $query->where(function($q) use ($user) {
                    $q->where('sender_id', auth()->id())
                      ->where('receiver_id', $user->id);
                })->orWhere(function($q) use ($user) {
                    $q->where('sender_id', $user->id)
                      ->where('receiver_id', auth()->id());
                });
            })->first();

        if ($existingConnection) {
            if ($existingConnection->status === 'pending') {
                return back()->with('error', 'Connection request already pending.');
            } elseif ($existingConnection->status === 'accepted') {
                return back()->with('error', 'You are already connected with this user.');
            }
        }

        Connection::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $user->id,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Connection request sent successfully.');
    }

    public function accept(Connection $connection)
    {
        if ($connection->receiver_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        if ($connection->status !== 'pending') {
            return back()->with('error', 'This request is no longer pending.');
        }

        $connection->update(['status' => 'accepted']);
        return back()->with('success', 'Connection request accepted.');
    }

    public function reject(Connection $connection)
    {
        if ($connection->receiver_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        if ($connection->status !== 'pending') {
            return back()->with('error', 'This request is no longer pending.');
        }

        $connection->delete();
        return back()->with('success', 'Connection request rejected.');
    }

    public function remove(Connection $connection)
    {
        if ($connection->sender_id !== auth()->id() && $connection->receiver_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        if ($connection->status !== 'accepted') {
            return back()->with('error', 'This connection is not active.');
        }

        $connection->delete();
        return back()->with('success', 'Connection removed successfully.');
    }
}
