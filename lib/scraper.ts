import axios from 'axios';

export interface Comment {
  id: string;
  text: string;
  author: string;
  authorAvatar?: string;
  likeCount: number;
  replyCount?: number;
  platform: 'youtube' | 'instagram' | 'tiktok';
  sentiment?: 'positive' | 'negative' | 'neutral';
  postedAt?: string; // Tanggal dan waktu komentar diposting
  scrapedAt: string;
}

// Helper function to format date
function formatDate(dateInput: string | number | Date | undefined): string | undefined {
  if (!dateInput) return undefined;
  
  try {
    let date: Date;
    
    if (typeof dateInput === 'number') {
      // Unix timestamp (seconds or milliseconds)
      date = dateInput > 9999999999 ? new Date(dateInput) : new Date(dateInput * 1000);
    } else if (typeof dateInput === 'string') {
      date = new Date(dateInput);
    } else {
      date = dateInput;
    }
    
    if (isNaN(date.getTime())) return undefined;
    
    return date.toISOString();
  } catch {
    return undefined;
  }
}

// Helper function to parse relative time (e.g., "2 days ago")
function parseRelativeTime(relativeTime: string | undefined): string | undefined {
  if (!relativeTime) return undefined;
  
  const now = new Date();
  const patterns = [
    { regex: /(\d+)\s*(second|sec|s)\s*ago/i, unit: 'seconds' },
    { regex: /(\d+)\s*(minute|min|m)\s*ago/i, unit: 'minutes' },
    { regex: /(\d+)\s*(hour|hr|h)\s*ago/i, unit: 'hours' },
    { regex: /(\d+)\s*(day|d)\s*ago/i, unit: 'days' },
    { regex: /(\d+)\s*(week|w)\s*ago/i, unit: 'weeks' },
    { regex: /(\d+)\s*(month|mo)\s*ago/i, unit: 'months' },
    { regex: /(\d+)\s*(year|yr|y)\s*ago/i, unit: 'years' },
  ];
  
  for (const { regex, unit } of patterns) {