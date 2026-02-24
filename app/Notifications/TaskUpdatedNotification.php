<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Task $task,
        public bool $created = false
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = route('tasks.show', $this->task);
        $projectTitle = $this->task->project->title;

        if ($this->created) {
            $subject = __('Task created: :title', ['title' => $this->task->title]);
            $line = __('A new task in project ":project" has been created.', ['project' => $projectTitle]);
        } else {
            $subject = __('Task updated: :title', ['title' => $this->task->title]);
            $line = __('A task in project ":project" has been updated.', ['project' => $projectTitle]);
        }

        return (new MailMessage)
            ->subject($subject)
            ->greeting(__('Hello :name,', ['name' => $notifiable->name]))
            ->line($line)
            ->line(__('Task: :title', ['title' => $this->task->title]))
            ->action(__('View task'), $url)
            ->line(__('Thank you for using TaskFlow!'));
    }
}
