import React from 'react';
import { Article } from '../types';
import { Clock } from 'lucide-react';

interface ArticleGridProps {
  articles: Article[];
}

export default function ArticleGrid({ articles }: ArticleGridProps) {
  return (
    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      {articles.map((article) => (
        <article key={article.id} className="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
          <img
            src={article.featuredImage}
            alt={article.title}
            className="w-full h-48 object-cover"
          />
          <div className="p-6">
            <h2 className="text-xl font-semibold mb-2 line-clamp-2">
              {article.title}
            </h2>
            <p className="text-gray-600 mb-4 line-clamp-3">
              {article.excerpt}
            </p>
            <div className="flex items-center justify-between">
              <div className="flex items-center space-x-2">
                <img
                  src={article.author.avatar}
                  alt={article.author.name}
                  className="w-8 h-8 rounded-full"
                />
                <span className="text-sm text-gray-700">{article.author.name}</span>
              </div>
              <div className="flex items-center text-gray-500">
                <Clock className="w-4 h-4 mr-1" />
                <time className="text-sm">
                  {new Date(article.publishedAt).toLocaleDateString()}
                </time>
              </div>
            </div>
          </div>
        </article>
      ))}
    </div>
  );
}