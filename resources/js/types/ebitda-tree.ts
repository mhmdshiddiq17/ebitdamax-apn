export type EbitdaValue = {
  revenue: number;
  doc_variable: number;
  doc_fixed: number;
  ioc: number;
  toc: number;
  ebitda: number;
  ebitda_margin: number | null;
};

export type EbitdaTreeNode = {
  id: number;
  slug: string;
  code: string;
  name: string;
  level: string | null;
  node_type: string | null;
  directorate_group: string | null;
  is_revenue_center: boolean;
  is_cost_center: boolean;
  depth: number;
  value_source: 'excel' | 'calculated_from_children' | 'empty';
  value: EbitdaValue;
  children: EbitdaTreeNode[];
};

export type EbitdaTreeOption = {
  id: number;
  slug: string;
  code: string;
  name: string;
  level: string | null;
};