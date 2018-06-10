<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Event;
use Symfony\Component\HttpFoundation\JsonResponse;

class EventController extends ApiController
{
        /**
     * @var Event
     */
    private $event;

    /**
     * EquipmentCategoriesController constructor.
     *
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $events = $this->event->get();
        return $this->respond($events);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $event = $this->event->findOrFail($id);

        return $this->respond($event);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $event = $this->event->create([
            'title' => $request->get('title'),
            'start' => $request->get('start'),
            'end' => $request->get('end'),
            'color' => $request->get('color'),
            'company_id' => auth()->user()->company_id         
        ]);

        return $this->respond(['message' => 'Event successfully created', 'event' => $event]);
    }

    /**
     * @param int $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $event = $this->event->findOrFail($id);
        $event->update([
            'title' => $request->get('title'),
            'start' => $request->get('start'),
            'end' => $request->get('end'),
            'color' => $request->get('color')
        ]);

        return $this->respond(['message' => 'Event successfully updated', 'event' => $event]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->event->findOrFail($id)->delete();

        return $this->respond(['message' => 'Event successfully deleted']);
    }
}
