<?php

namespace App\Livewire\Admin\Contact;

use App\Models\ContactMessage;
use App\Services\ContactService;
use Livewire\Component;
use Livewire\WithPagination;

class ContactMessages extends Component
{
    use WithPagination;

    public $filterStatus = '';
    public $selectedMessage = null;
    public $showModal = false;

    public function viewMessage($id)
    {
        $this->selectedMessage = ContactMessage::findOrFail($id);
        
        // Mark as read if it's new
        if ($this->selectedMessage->status === 'new') {
            $this->selectedMessage->markAsRead();
        }
        
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedMessage = null;
    }

    public function markAsReplied($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->markAsReplied();
        
        session()->flash('success', 'Message marked as replied!');
        
        if ($this->selectedMessage && $this->selectedMessage->id === $id) {
            $this->selectedMessage = $message->fresh();
        }
    }

    public function delete($id, ContactService $service)
    {
        $message = ContactMessage::findOrFail($id);
        $service->deleteMessage($message);
        
        session()->flash('success', 'Message deleted successfully!');
        
        if ($this->selectedMessage && $this->selectedMessage->id === $id) {
            $this->closeModal();
        }
    }

    public function render()
    {
        $query = ContactMessage::orderBy('created_at', 'desc');
        
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        return view('livewire.admin.contact.contact-messages', [
            'messages' => $query->paginate(20),
            'newCount' => ContactMessage::new()->count(),
            'readCount' => ContactMessage::read()->count(),
            'repliedCount' => ContactMessage::replied()->count(),
        ])->layout('layouts.admin');
    }
}
