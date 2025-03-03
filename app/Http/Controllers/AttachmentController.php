<?php

namespace App\Http\Controllers;

use App\Models\PostAttachment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentController extends Controller {

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif|max:10240', // Ensure only image files are uploaded
        ]);

        $file = $request->file('file');

        // Generate a unique filename to avoid conflicts
        $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();

        // Store file in `storage/app/public/attachments/`
        $path = $file->storeAs('public/attachments', $filename);

        // Save attachment details in the database
        $attachment = new PostAttachment();
        $attachment->post_id = $request->post_id;
        $attachment->user_id = auth()->id();
        $attachment->file_path = str_replace('public/', '', $path); // Save only the relative path
        $attachment->file_name = $filename;
        $attachment->file_type = $file->getMimeType();
        $attachment->file_size = $file->getSize();
        $attachment->save();

        return redirect()->route('posts.show', $request->post_id)
            ->with('success', 'Attachment uploaded successfully.');
    }

    public function download(PostAttachment $attachment)
    {
        return response()->download(storage_path('app/public/' . $attachment->file_path), $attachment->file_name);
    }

    public function destroy(PostAttachment $attachment)
    {
        Storage::delete('public/' . $attachment->file_path);
        $attachment->delete();

        return redirect()->route('posts.show', $attachment->post_id)
            ->with('success', 'Attachment deleted successfully.');
    }
}

