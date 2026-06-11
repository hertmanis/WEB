<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    // Show all feedback (optional: only user-specific feedback)
    public function index()
    {
        $feedback = Feedback::where('user_id', Auth::id())->get();
        return view('feedback.index', compact('feedback'));
    }

    // Show the form to create new feedback
    public function create()
    {
        return view('feedback.create');
    }

    // Store feedback in the database
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'rating' => 'nullable|integer|min:1|max:10',
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'rating' => $request->rating,
        ]);

        return redirect()->route('feedback.index')->with('success', 'Feedback submitted successfully!');
    }

    public function showPracticeFeedback($practiceId)
    {
        $practice = Practice::with('feedback.user')->findOrFail($practiceId);

        return view('coach.practices.feedback', compact('practice'));
    }
}
