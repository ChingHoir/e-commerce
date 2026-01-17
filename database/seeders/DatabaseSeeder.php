<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Author;
use App\Models\Article;
use App\Models\Audience;
use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        echo "\n=== STARTING DATABASE SEEDING ===\n\n";

        // Task 3.1: Create authors (with user accounts)
        echo "1. Creating Authors with User Accounts...\n";
        
        $userSok = User::create([
            'name' => 'sok123',
            'email' => 'sok123@example.com',
            'password' => Hash::make('password'),
        ]);
        $authorSok = Author::create([
            'name' => 'Sok',
            'user_id' => $userSok->id,
        ]);
        echo "   - Created Author Sok with username: sok123\n";

        $userSao = User::create([
            'name' => 'sao',
            'email' => 'sao@example.com',
            'password' => Hash::make('password'),
        ]);
        $authorSao = Author::create([
            'name' => 'Sao',
            'user_id' => $userSao->id,
        ]);
        echo "   - Created Author Sao with username: sao\n";

        $userDara = User::create([
            'name' => 'd.dara',
            'email' => 'd.dara@example.com',
            'password' => Hash::make('password'),
        ]);
        $authorDara = Author::create([
            'name' => 'Dara',
            'user_id' => $userDara->id,
        ]);
        echo "   - Created Author Dara with username: d.dara\n\n";

        // Task 3.2: Create articles
        echo "2. Creating Articles...\n";
        
        $articleClimate = Article::create([
            'title' => 'Climate changes in the last 3 years',
            'author_id' => $authorSok->id,
        ]);
        echo "   - Author Sok wrote: 'Climate changes in the last 3 years'\n";

        $articleWarming = Article::create([
            'title' => 'Global warming is in its critical stage',
            'author_id' => $authorSok->id,
        ]);
        echo "   - Author Sok wrote: 'Global warming is in its critical stage'\n";

        $articleComputers = Article::create([
            'title' => 'Computers in the next generation',
            'author_id' => $authorSao->id,
        ]);
        echo "   - Author Sao wrote: 'Computers in the next generation'\n";

        $articleQuantum = Article::create([
            'title' => 'Quantum computers, is it coming?',
            'author_id' => $authorSao->id,
        ]);
        echo "   - Author Sao wrote: 'Quantum computers, is it coming?'\n";

        $articleChemistry = Article::create([
            'title' => 'Chemistry in nature form',
            'author_id' => $authorDara->id,
        ]);
        echo "   - Author Dara wrote: 'Chemistry in nature form'\n";

        $articleWater = Article::create([
            'title' => 'The origin of water',
            'author_id' => $authorDara->id,
        ]);
        echo "   - Author Dara wrote: 'The origin of water'\n\n";

        // Task 3.3: Create audiences
        echo "3. Creating Audiences...\n";
        
        $userVeasna = User::create([
            'name' => 'veasna',
            'email' => 'veasna@example.com',
            'password' => Hash::make('password'),
        ]);
        $audienceVeasna = Audience::create([
            'name' => 'Veasna',
            'user_id' => $userVeasna->id,
        ]);
        echo "   - Created Audience Veasna with username: veasna\n";

        $userSamnang = User::create([
            'name' => 'samnang',
            'email' => 'samnang@example.com',
            'password' => Hash::make('password'),
        ]);
        $audienceSamnang = Audience::create([
            'name' => 'Samnang',
            'user_id' => $userSamnang->id,
        ]);
        echo "   - Created Audience Samnang with username: samnang\n";

        $userRatana = User::create([
            'name' => 'ratana',
            'email' => 'ratana@example.com',
            'password' => Hash::make('password'),
        ]);
        $audienceRatana = Audience::create([
            'name' => 'Ratana',
            'user_id' => $userRatana->id,
        ]);
        echo "   - Created Audience Ratana with username: ratana\n\n";

        // Task 3.4: Subscribe audiences to articles
        echo "4. Subscribing Audiences to Articles...\n";
        
        $audienceSamnang->articles()->attach([
            $articleComputers->id,
            $articleChemistry->id,
            $articleWater->id,
        ]);
        echo "   - Samnang subscribed to: 'Computers in the next generation', 'Chemistry in nature form', 'The origin of water'\n";

        $audienceVeasna->articles()->attach([
            $articleClimate->id,
            $articleWater->id,
            $articleQuantum->id,
        ]);
        echo "   - Veasna subscribed to: 'Climate changes in the last 3 years', 'The origin of water', 'Quantum computers, is it coming?'\n";

        $audienceRatana->articles()->attach([
            $articleClimate->id,
            $articleWarming->id,
        ]);
        echo "   - Ratana subscribed to: 'Climate changes in the last 3 years', 'Global warming is in its critical stage'\n\n";

        // Task 3.5: Create comments
        echo "5. Creating Comments...\n";
        
        Comment::create([
            'content' => 'Thank you to all the subscribers',
            'user_id' => $userSok->id,
            'commentable_type' => Article::class,
            'commentable_id' => $articleClimate->id,
        ]);
        echo "   - Author Sok commented on article 'Climate changes in the last 3 years': 'Thank you to all the subscribers'\n";

        Comment::create([
            'content' => 'Your article is amazing',
            'user_id' => $userSamnang->id,
            'commentable_type' => Author::class,
            'commentable_id' => $authorSao->id,
        ]);
        echo "   - Audience Samnang commented on Author Sao: 'Your article is amazing'\n";

        Comment::create([
            'content' => 'Welcome to read my article',
            'user_id' => $userSao->id,
            'commentable_type' => Audience::class,
            'commentable_id' => $audienceSamnang->id,
        ]);
        echo "   - Author Sao commented on Audience Samnang: 'Welcome to read my article'\n";

        Comment::create([
            'content' => 'I can\'t wait this thing happening',
            'user_id' => $userVeasna->id,
            'commentable_type' => Article::class,
            'commentable_id' => $articleQuantum->id,
        ]);
        echo "   - Audience Veasna commented on article 'Quantum computers, is it coming?': 'I can't wait this thing happening'\n\n";

        // Task 3.6: Query the database
        echo "=== QUERY RESULTS ===\n\n";

        // Get all articles of author Sao
        echo "6.1. All articles by Author Sao:\n";
        $saoArticles = $authorSao->articles;
        foreach ($saoArticles as $article) {
            echo "   - {$article->title}\n";
        }
        echo "\n";

        // Get all audiences of article "Climate changes in the last 3 years"
        echo "6.2. All audiences of article 'Climate changes in the last 3 years':\n";
        $climateAudiences = $articleClimate->audiences;
        foreach ($climateAudiences as $audience) {
            echo "   - {$audience->name} (username: {$audience->user->name})\n";
        }
        echo "\n";

        // Get all audiences of author Sok (using Has Many Through)
        echo "6.3. All audiences of Author Sok (using Has Many Through):\n";
        $sokAudiences = $authorSok->audiences()->get();
        foreach ($sokAudiences as $audience) {
            echo "   - {$audience->name} (username: {$audience->user->name})\n";
        }
        echo "\n";

        // Get all comments of audience Samnang
        echo "6.4. All comments of Audience Samnang:\n";
        $samnangComments = $audienceSamnang->comments;
        foreach ($samnangComments as $comment) {
            echo "   - \"{$comment->content}\"\n";
        }
        echo "\n";

        // Get all comments with their commentable topics
        echo "6.5. All comments with their topics:\n";
        $allComments = Comment::with('commentable', 'user')->get();
        foreach ($allComments as $comment) {
            $commentableType = class_basename($comment->commentable_type);
            $commentableName = '';
            
            if ($commentableType === 'Article') {
                $commentableName = $comment->commentable->title;
            } elseif ($commentableType === 'Author') {
                $commentableName = $comment->commentable->name;
            } elseif ($commentableType === 'Audience') {
                $commentableName = $comment->commentable->name;
            }
            
            echo "   - {$comment->user->name} commented on {$commentableType} '{$commentableName}': \"{$comment->content}\"\n";
        }

        echo "\n=== SEEDING COMPLETED SUCCESSFULLY ===\n";
    }
}

