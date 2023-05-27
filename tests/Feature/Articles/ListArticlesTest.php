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

        $response->assertExactJson([
            'data' => [
                'type' => 'articles',
                'id' => (string) $article->getRouteKey(),
                'attributes' => [
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'content' => $article->content,
                ],
                'links' => [
                    'self' => route('api.v1.articles.show', $article)
                ]
            ]
        ]);
    }

    /** @test */
    public function can_fetch_all_articles()
    {
        $this->withoutExceptionHandling();
        $articles = Article::factory()->count(3)->create();
        $response = $this->getJson(route('api.v1.articles.index'));

        // Se genera parte del arreglo a comparar
        foreach ($articles as $article) {
            $data[] = [
                'type' => 'articles',
                    'id' => (string) $article->getRouteKey(),
                    'attributes' => [
                        'title' => $article->title,
                        'slug' => $article->slug,
                        'content' => $article->content,
                    ],
                    'links' => [
                        'self' => route('api.v1.articles.show', $article),
                    ],
            ];
        }

        // Se adjuntan los links al arreglo y se hace la comparación
        $response->assertExactJson([
            'data' => $data,
            'links' => [
                'self' => route('api.v1.articles.index'),
            ]
        ]);
    }
}