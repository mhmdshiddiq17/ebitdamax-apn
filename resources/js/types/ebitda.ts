export type EbitdaValue = {
  revenue: number;
  doc_variable: number;
  doc_fixed: number;
  ioc: number;
  toc: number;
  ebitda: number;
  ebitda_margin: number | null;
};

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

export type EbitdaTreeNode = {
  id: number;
  slug: string;
  code: string;
  name: string;
  level: string | null;
  is_revenue_center: boolean;
  is_cost_center: boolean;
  value: EbitdaValue;
  children: EbitdaTreeNode[];
};