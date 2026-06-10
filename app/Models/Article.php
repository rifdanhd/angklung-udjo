<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category',
        'external_url',
        'is_published',
        'published_at',
        'views'
    ];
    
    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($article) {
            $article->slug = Str::slug($article->title);
        });
        
        static::updating(function ($article) {
            $article->slug = Str::slug($article->title);
        });
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
    
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
    
    public function incrementViews()
    {
        $this->increment('views');
    }
    
    public function getReadingTimeAttribute()
    {
        $words = str_word_count(strip_tags($this->content));
        $minutes = ceil($words / 200);
        return $minutes . ' menit baca';
    }
    
    // ← TAMBAHKAN METHOD INI
    public function isExternal()
    {
        return !empty($this->external_url);
    }
     // ← TAMBAHKAN INI
    public function images()
    {
        return $this->hasMany(ArticleImage::class)->orderBy('order');
    }

}  // ← kurung penutup class