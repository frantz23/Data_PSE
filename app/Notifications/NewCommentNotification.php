<?php

namespace App\Notifications;

use App\Models\IndicatorValueComment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification
{
    use Queueable;

    public $comment;

    /**
     * Reçoit le commentaire de l'indicateur
     */
    public function __construct(IndicatorValueComment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Canal d'envoi : BDD
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Données stockées dans la table "notifications"
     */
    public function toDatabase(object $notifiable): array
    {
        $authorName = $this->comment->user->name ?? 'Un utilisateur';

        return [
            'comment_id'         => $this->comment->id,
            'indicator_value_id' => $this->comment->indicator_value_id,
            'user_name'          => $authorName,
            'message'            => "{$authorName} a laissé une note sur une valeur d'indicateur.",

            // ⚠️ Utilisé par votre méthode markAsRead()
            // (Ajustez 'showIndicator' avec le nom réel de votre route de consultation)
            'url'                => route('showIndicator', $this->comment->indicator_value_id),
            'created_at'         => now()->toDateTimeString(),
        ];
    }
}
