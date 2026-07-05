export type OrganizationProfileItem = {
    id: number;
    organization_id: number;
    parent_id: number | null;
    code: string | null;
    name: string | null;
    level: string | null;
    node_type: string | null;
    directorate_group: string | null;
    is_revenue_center: boolean | null;
    is_cost_center: boolean | null;
    depth: number | null;
    path: string | null;
    source_sheet: string | null;
    job_description: string | null;
    qualification: string | null;
    value_chain: string | null;
    method_cost: number | null;
};

export type OrganizationProfileSummary = {
    total_profiles: number;
    with_jobdesk: number;
    with_value_chain: number;
    total_organizations: number;
};

export type ValueChainJobdeskFilters = {
    search: string;
    mode: 'all' | 'value_chain' | 'jobdesk';
};
