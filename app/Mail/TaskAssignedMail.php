<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskAssignedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
// La tâche sera disponible dans toute la classe
    public Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle Tâche Assignée : ' . $this->task->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tasks.assigned',
        );
    }
}
