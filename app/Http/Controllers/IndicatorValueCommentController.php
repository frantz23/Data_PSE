<?php

namespace App\Http\Controllers;

use App\Models\IndicatorValue;
use App\Models\IndicatorValueComment;
use App\Notifications\NewCommentNotification;
use Illuminate\Http\Request;

class IndicatorValueCommentController extends Controller
{
    //
    /**
     * Enregistrer une nouvelle note / réponse
     */
    public function store(Request $request, $indicatorValueId)
    {
        $request->validate([
            'content' => 'required|string|max:1500',
            'indicator_value_comment_id' => 'nullable|exists:indicatorvaluecomments,id',
        ]);

        $indicatorValue = IndicatorValue::findOrFail($indicatorValueId);

        // 1. Création du commentaire
        $comment = IndicatorValueComment::create([
            'indicator_value_id' => $indicatorValue->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
            'indicator_value_comment_id' => $request->indicator_value_comment_id ?? null,
        ]);

        // 2. Notification : Envoi à la personne concernée (auteur de la collecte si l'admin commente, ou l'inverse)
        $recipient = $indicatorValue->user;

        if ($recipient && $recipient->id !== auth()->id()) {
            $recipient->notify(new NewCommentNotification($comment));
        }

        return back()->with('success', 'Votre note a bien été enregistrée.');
    }

    /**
     * Marquer la notification comme lue et rediriger vers la collecte
     */
    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();

        return redirect($notification->data['url'] ?? route('dashboard'));
    }
}
