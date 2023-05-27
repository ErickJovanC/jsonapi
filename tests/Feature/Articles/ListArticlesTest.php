<?php
namespace Tests\Feature\Articles;

use Tests\TestCase;
use App\Models\Article;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListArticlesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_a_single_article(): void
    {
        $this->withoutExceptionHandling(); // Devuelve un error más especifico
        $article = Article::factory()->create();
        $response = $this->getJson('/api/v1/articles/' . $article->getRouteKey());
        // El método getRouteKey() se utiliza para obtener el valor de la clave primaria del modelo para generar la URL.
        $response->assertSee($article->title);
    }
}