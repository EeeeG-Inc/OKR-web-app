<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository implements CommentRepositoryInterface
{
    /** @var Comment */
    private $comment;

    public function __construct(Comment $comment = null)
    {
        $this->comment = $comment ?? new Comment;
    }

    public function find(int $id): ?Comment
    {
        return $this->comment->findOrFail($id);
    }

    public function create(array $input): Comment
    {
        return $this->comment->create($input);
    }

    public function update(int $id, array $input): bool
    {
        $model = $this->comment->findOrFail($id);
        $model->fill($input);
        return $model->save();
    }

    public function delete(Comment $target): bool
    {
        return $target->delete();
    }

    public function getByObjectiveId(int $objectiveId): Collection
    {
        return Comment::where('objective_id', $objectiveId)->get();
    }
}
