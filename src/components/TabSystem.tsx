import React from 'react';
import { TabType } from '../types';

interface TabSystemProps {
  activeTab: TabType;
  onTabChange: (tab: TabType) => void;
}

export default function TabSystem({ activeTab, onTabChange }: TabSystemProps) {
  return (
    <div className="flex space-x-1 bg-gray-100 p-1 rounded-lg mb-8">
      <button
        onClick={() => onTabChange('latest')}
        className={`flex-1 py-2.5 px-4 rounded-md text-sm font-medium transition-colors ${
          activeTab === 'latest'
            ? 'bg-white text-gray-900 shadow'
            : 'text-gray-600 hover:text-gray-900'
        }`}
      >
        Latest
      </button>
      <button
        onClick={() => onTabChange('popular')}
        className={`flex-1 py-2.5 px-4 rounded-md text-sm font-medium transition-colors ${
          activeTab === 'popular'
            ? 'bg-white text-gray-900 shadow'
            : 'text-gray-600 hover:text-gray-900'
        }`}
      >
        Most Popular
      </button>
      <button
        onClick={() => onTabChange('editors-picks')}
        className={`flex-1 py-2.5 px-4 rounded-md text-sm font-medium transition-colors ${
          activeTab === 'editors-picks'
            ? 'bg-white text-gray-900 shadow'
            : 'text-gray-600 hover:text-gray-900'
        }`}
      >
        Editor's Picks
      </button>
    </div>
  );
}