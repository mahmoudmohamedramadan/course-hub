<?php

namespace App\Livewire;

use App\Models\Level;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Repositories\Course as CourseRepository;

class CourseCatalog extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $categoryId = '';

    #[Url]
    public string $levelId = '';

    #[Url(except: 'newest')]
    public string $sort = 'newest';

    /**
     * Course repository.
     *
     * @var \App\Repositories\Course
     */
    protected $repository;

    public function boot(CourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function updated($property)
    {
        if (in_array($property, ['search', 'categoryId', 'levelId', 'sort'], true)) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $courses = $this->repository->search($this->search, $this->categoryId, $this->levelId, $this->sort);

        return view('livewire.course-catalog', [
            'courses'    => $courses,
            'categories' => Category::orderBy('name')->get(['id', 'name']),
            'levels'     => Level::orderBy('name')->get(['id', 'name']),
        ]);
    }
}
