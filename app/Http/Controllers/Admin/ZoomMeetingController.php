<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ZoomMeeting;
use App\Services\ZoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ZoomMeetingController extends Controller
{
    public function index()
    {
        $meetings = ZoomMeeting::orderBy('start_time', 'desc')->get();

        return view('admin.zoom-meetings.index', compact('meetings'));
    }

    public function create()
    {
        return view('admin.zoom-meetings.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'topic' => 'required|string|max:255',
            'agenda' => 'nullable|string',
            'start_time' => 'required|date',
            'duration' => 'required|integer|min:15|max:480',
            'timezone' => 'nullable|string|max:50',
        ]);

        $zoomService = new ZoomService();

        try {
            $startTime = Carbon::parse($data['start_time'])->format('Y-m-d\TH:i:s\Z');

            $zoomResponse = $zoomService->createMeeting(
                topic: $data['topic'],
                startTime: $startTime,
                duration: $data['duration'],
                timezone: $data['timezone'] ?? 'Asia/Kolkata',
                agenda: $data['agenda']
            );

            ZoomMeeting::create([
                'meeting_id' => $zoomResponse['id'] ?? null,
                'topic' => $data['topic'],
                'agenda' => $data['agenda'],
                'start_time' => $data['start_time'],
                'duration' => $data['duration'],
                'timezone' => $data['timezone'] ?? 'Asia/Kolkata',
                'join_url' => $zoomResponse['join_url'] ?? null,
                'start_url' => $zoomResponse['start_url'] ?? null,
                'password' => $zoomResponse['password'] ?? null,
                'host_email' => $zoomResponse['host_email'] ?? null,
                'host_join_url' => $zoomResponse['host_join_url'] ?? null,
                'status' => 'scheduled',
                'type' => 'scheduled',
                'created_by' => Auth::id(),
            ]);

            return redirect()->route('admin.zoom-meetings.index')
                ->with('success', 'Zoom Meeting Created Successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create Zoom meeting: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(ZoomMeeting $zoomMeeting)
    {
        return view('admin.zoom-meetings.show', compact('zoomMeeting'));
    }

    public function edit(ZoomMeeting $zoomMeeting)
    {
        return view('admin.zoom-meetings.form', compact('zoomMeeting'));
    }

    public function update(Request $request, ZoomMeeting $zoomMeeting)
    {
        $data = $request->validate([
            'topic' => 'required|string|max:255',
            'agenda' => 'nullable|string',
            'start_time' => 'required|date',
            'duration' => 'required|integer|min:15|max:480',
            'timezone' => 'nullable|string|max:50',
        ]);

        $zoomService = new ZoomService();

        try {
            if ($zoomMeeting->meeting_id) {
                $startTime = Carbon::parse($data['start_time'])->format('Y-m-d\TH:i:s\Z');

                $zoomService->updateMeeting(
                    meetingId: $zoomMeeting->meeting_id,
                    topic: $data['topic'],
                    startTime: $startTime,
                    duration: $data['duration'],
                    timezone: $data['timezone'] ?? 'Asia/Kolkata',
                    agenda: $data['agenda']
                );
            }

            $zoomMeeting->update([
                'topic' => $data['topic'],
                'agenda' => $data['agenda'],
                'start_time' => $data['start_time'],
                'duration' => $data['duration'],
                'timezone' => $data['timezone'] ?? 'Asia/Kolkata',
            ]);

            return redirect()->route('admin.zoom-meetings.index')
                ->with('success', 'Zoom Meeting Updated Successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update Zoom meeting: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(ZoomMeeting $zoomMeeting)
    {
        $zoomService = new ZoomService();

        try {
            if ($zoomMeeting->meeting_id) {
                $zoomService->deleteMeeting($zoomMeeting->meeting_id);
            }

            $zoomMeeting->delete();

            return redirect()->route('admin.zoom-meetings.index')
                ->with('success', 'Zoom Meeting Deleted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete Zoom meeting: ' . $e->getMessage());
        }
    }

    public function startMeeting(ZoomMeeting $zoomMeeting)
    {
        $zoomService = new ZoomService();

        try {
            if ($zoomMeeting->meeting_id) {
                $zoomService->updateMeeting(
                    meetingId: $zoomMeeting->meeting_id,
                    topic: $zoomMeeting->topic,
                    startTime: Carbon::parse($zoomMeeting->start_time)->format('Y-m-d\TH:i:s\Z'),
                    duration: $zoomMeeting->duration,
                    timezone: $zoomMeeting->timezone,
                    agenda: $zoomMeeting->agenda
                );
            }

            $zoomMeeting->update(['status' => 'started']);

            return redirect($zoomMeeting->join_url)
                ->with('success', 'Meeting started');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to start meeting: ' . $e->getMessage());
        }
    }

    public function endMeeting(ZoomMeeting $zoomMeeting)
    {
        $zoomService = new ZoomService();

        try {
            if ($zoomMeeting->meeting_id) {
                $zoomService->endMeeting($zoomMeeting->meeting_id);
            }

            $zoomMeeting->update(['status' => 'ended']);

            return redirect()->route('admin.zoom-meetings.index')
                ->with('success', 'Meeting Ended Successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to end meeting: ' . $e->getMessage());
        }
    }

    public function syncMeeting(ZoomMeeting $zoomMeeting)
    {
        $zoomService = new ZoomService();

        try {
            if ($zoomMeeting->meeting_id) {
                $meetingData = $zoomService->getMeeting($zoomMeeting->meeting_id);

                $zoomMeeting->update([
                    'topic' => $meetingData['topic'] ?? $zoomMeeting->topic,
                    'agenda' => $meetingData['agenda'] ?? $zoomMeeting->agenda,
                    'duration' => $meetingData['duration'] ?? $zoomMeeting->duration,
                    'status' => $meetingData['status'] ?? $zoomMeeting->status,
                    'join_url' => $meetingData['join_url'] ?? $zoomMeeting->join_url,
                ]);
            }

            return redirect()->route('admin.zoom-meetings.index')
                ->with('success', 'Meeting Synced Successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to sync meeting: ' . $e->getMessage());
        }
    }
}