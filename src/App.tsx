import React, { useState } from 'react';
import Navigation from './components/Navigation';
import TabSystem from './components/TabSystem';
import ArticleGrid from './components/ArticleGrid';
import { Article, TabType } from './types';

// Mock data for demonstration
const mockArticles: Article[] = [
  {
    id: '1',
    title: 'The Future of AI in Modern Technology',
    excerpt: 'Exploring how artificial intelligence is reshaping our technological landscape and what it means for the future.',
    content: '',
    featuredImage: 'https://images.unsplash.com/photo-1677442136019-21780ecad995',
    author: {
      id: '1',
      name: 'John Doe',
      avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e',
    },
    category: 'Technology',
    publishedAt: '2024-02-25T12:00:00Z',
    viewsCount: 1250,
  },
  {
    id: '2',
    title: 'Sustainable Living: A Guide to Eco-Friendly Practices',
    excerpt: 'Learn how small changes in your daily routine can contribute to a more sustainable future.',
    content: '',
    featuredImage: 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09',
    author: {
      id: '2',
      name: 'Jane Smith',
      avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80',
    },
    category: 'Lifestyle',
    publishedAt: '2024-02-24T15:30:00Z',
    viewsCount: 980,
  },
  {
    id: '3',
    title: 'The Rise of Remote Work Culture',
    excerpt: 'How companies are adapting to the new normal of remote work and its impact on workplace culture.',
    content: '',
    featuredImage: 'https://images.unsplash.com/photo-1587560699334-cc4ff634909a',
    author: {
      id: '3',
      name: 'Mike Johnson',
      avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e',
    },
    category: 'Business',
    publishedAt: '2024-02-23T09:15:00Z',
    viewsCount: 1500,
  },
];

function App() {
  const [activeTab, setActiveTab] = useState<TabType>('latest');

  return (
    <div className="min-h-screen bg-gray-50">
      <Navigation />
      <main className="container mx-auto px-4 pt-24 pb-12">
        <TabSystem activeTab={activeTab} onTabChange={setActiveTab} />
        <ArticleGrid articles={mockArticles} />
      </main>
    </div>
  );
}

export default App;