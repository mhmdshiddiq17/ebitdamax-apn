import type { EbitdaTreeNode, EbitdaValue } from './ebitda-tree';

export type DirectorateDashboardItem = {
  id: number;
  slug: string;
  code: string;
  name: string;
  level: string | null;
  is_revenue_center: boolean;
  is_cost_center: boolean;
  value: EbitdaValue;
};

export type ChartItem = {
  code?: string;
  name: string;
  label: string;
  value: number;
};

export type NegativeEbitdaAlert = {
  organization_id: number;
  code: string | null;
  name: string | null;
  level: string | null;
  revenue: number;
  toc: number;
  ebitda: number;
  ebitda_margin: number | null;
};

export type DashboardCharts = {
  revenue_by_directorate: ChartItem[];
  cost_breakdown: ChartItem[];
  ebitda_by_directorate: ChartItem[];
  margin_ranking: ChartItem[];
};

export type DashboardAlerts = {
  negative_ebitda: NegativeEbitdaAlert[];
};

export type ExecutiveDashboardProps = {
  year: number;
  scenario: string;
  summary: EbitdaValue;
  directorates: DirectorateDashboardItem[];
  charts: DashboardCharts;
  alerts: DashboardAlerts;
};

export type DirectorateDashboardProps = {
  year: number;
  scenario: string;
  directorate: {
    id: number;
    slug: string;
    code: string;
    name: string;
  };
  summary: EbitdaValue;
  tree: EbitdaTreeNode;
  charts: DashboardCharts;
  alerts: DashboardAlerts;
};