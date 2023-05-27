<?php

namespace Tests\Feature\Articles;

use Tests\TestCase;
use App\Models\Article;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function can_create_articles(): void
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson(route('api.v1.articles.create'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'title' => 'Test Article',
                    'slug' => 'test-article',
                    'content' => 'Test Article Content',
                ]
            ]
        ]);

        $response->assertCreated();

        $article = Article::first();

        $response->assertExactJson([
            'data' => [
                'type' => 'articles',
                'id' => (string) $article->getRouteKey(),
                'attributes' => [
                    'title' => 'Test Article',
                    'slug' => 'test-article',
                    'content' => 'Test Article Content',
                ],
                'links' => [
                    'self' => route('api.v1.articles.show', $article)
                ]
            ]
        ]);

        $response->assertHeader(
            'Location',
            route('api.v1.articles.show', $article)
        );
    }
}