export interface Article {
  id: string;
  title: string;
  excerpt: string;
  content: string;
  featuredImage: string;
  author: {
    id: string;
    name: string;
    avatar: string;
  };
  category: string;
  publishedAt: string;
  viewsCount: number;
}

export type TabType = 'latest' | 'popular' | 'editors-picks';