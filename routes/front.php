<?php

use App\Http\Controllers\Front\ArticleController;
use App\Http\Controllers\Front\CourseController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ResourceController;
use App\Http\Controllers\Front\TutorialController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('articulos', [ArticleController::class, 'index'])->name('front.articles.index');
Route::get('articulos/{article:slug}', [ArticleController::class, 'show'])->name('front.articles.show');

Route::get('tutoriales', [TutorialController::class, 'index'])->name('front.tutorials.index');
Route::get('tutoriales/{tutorial:slug}', [TutorialController::class, 'show'])->name('front.tutorials.show');

Route::get('cursos', [CourseController::class, 'index'])->name('front.courses.index');
Route::get('cursos/{course:slug}', [CourseController::class, 'show'])->name('front.courses.show');
Route::get('cursos/{course:slug}/{lesson:slug}', [CourseController::class, 'lesson'])->name('front.courses.lesson');

Route::get('recursos', [ResourceController::class, 'index'])->name('front.resources.index');
Route::get('recursos/{resource:slug}', [ResourceController::class, 'show'])->name('front.resources.show');

Route::view('metodologia', 'front.methodology')->name('front.methodology');
Route::view('planes', 'front.plans')->name('front.plans');
