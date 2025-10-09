<?php

namespace App\Services;

use App\Models\Ticket;
use App\Repositories\TicketRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class TicketService
{
    protected TicketRepository $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function getAll(array $filters = [])
    {
        return $this->ticketRepository->filter($filters);
    }

    public function getById(int $id)
    {
        return $this->ticketRepository->findById($id);
    }

    public function findByUuid(string $uuid)
    {
        $ticket = $this->ticketRepository->findByUuid($uuid);
        if (!$ticket) {
            throw new ModelNotFoundException("Ticket not found");
        }
        return $ticket;
    }

    public function create(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                $data['user_id'] = $data['user_id'] ?? Auth::id();
                $data['ticket_from'] = Auth::user()->role;
                return $this->ticketRepository->create($data);
            });
        } catch (Exception $e) {
            throw new Exception("Failed to create ticket: " . $e->getMessage());
        }
    }

    public function update(Ticket $ticket, array $data)
    {
        if($ticket->user_id  != Auth::id() && Auth::user()->role != 'admin'){
            throw new Exception("You do not have permission to update this ticket");
        }
        return $this->ticketRepository->update($ticket, $data);
    }

    public function delete(Ticket $ticket)
    {
        if($ticket->user_id  != Auth::id() && Auth::user()->role != 'admin'){
            throw new Exception("You do not have permission to delete this ticket");
        }
        return $this->ticketRepository->delete($ticket);
    }

    public function changeStatus(int $id, string $status)
    {
        if (!in_array($status, ['open', 'solved', 'closed', 'hold'])) {
            throw new Exception("Invalid status provided");
        }

        return $this->ticketRepository->updateStatus($id, $status);
    }

    public function getUserTickets(int $userId)
    {
        return $this->ticketRepository->getUserTickets($userId);
    }

    public function replyToTicket(array $data)
    {
        try {
            return $this->ticketRepository->replyToTicket($data);
        } catch (Exception $e) {
            throw new Exception("Failed to send reply: " . $e->getMessage());
        }
    }
}
