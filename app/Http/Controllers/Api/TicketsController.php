<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Models\Ticket;
use App\Models\TicketCategory;

class TicketsController extends ApiController
{
    /**
     * @var Ticket
     */
    private $ticket;

    /**
     * @var TicketCategory
     */
    private $ticketCategory;

    /**
     * Ticket constructor.
     *
     * @param Ticket $ticket
     * @param TicketCategory $ticketCategory
     */
    public function __construct(Ticket $ticket, TicketCategory $ticketCategory)
    {
        $this->ticket = $ticket;
        $this->ticketCategory = $ticketCategory;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $ticketCategories = $this->ticketCategory->get(); 
        $tickets = $this->ticket
            ->with(['ticketCategory'])
            ->paginate($request->get('per_page')); 
        return $this->respond([
            'tickets' => $tickets,
            'ticket_categories' => $ticketCategories
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getCategories(Request $request): JsonResponse
    {
        $ticketCategories = $this->ticketCategory->get();
        return $this->respond($ticketCategories);
    }
    
    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $ticket = $this->ticket->findOrFail($id);

        return $this->respond($ticket);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'title'     => 'required',
            'category'  => 'required',
            'priority'  => 'required',
            'message'   => 'required'
        ]);

        //sendmail

        $ticket = $this->ticket->create([
            'title'     => $request->input('title'),
            'user_id'   => auth()->user()->id,
            'ticket_id' => strtoupper(str_random(10)),
            'category_id'  => $request->input('category'),
            'priority'  => $request->input('priority'),
            'message'   => $request->input('message'),
            'status'    => "Open",
        ]);

        return $this->respond(['message' => "A ticket with ID: #$ticket->ticket_id has been opened.", 'ticket' => $ticket]);
    }

    // /**
    //  * @param int $id
    //  *
    //  * @return JsonResponse
    //  */
    // public function destroy(int $id): JsonResponse
    // {
    //     $this->team->findOrFail($id)->delete();

    //     return $this->respond(['message' => 'Team successfully deleted']);
    // }
}
