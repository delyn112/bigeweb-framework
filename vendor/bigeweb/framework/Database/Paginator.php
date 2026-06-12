<?php

namespace illuminate\Support\Database;

class Paginator
{
    private $mainSelf;

    //public function paginates(int $number_per_page, $currentPage = 1)
    protected function internalPaginator($data)
    {
        $self = $this;

        if(!$self->row_per_page > 0)
        {
            return;
        }
        $self->total_records = $self->count();
        //calculate the total pages
        $this->total_pages = ceil($self->total_records / $self->row_per_page);
        $offset = ($this->current_page - 1) * $self->row_per_page;
        $self->limit($self->row_per_page, $offset);
        $this->mainSelf = $self;
        return $self;
    }


    public function pagination_link()
    {
        $paginatedData = $this->mainSelf;
        $html = '<ul class="pagination bgw-pagination mb-0">';

// Parse the current URL
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $query = [];
        parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $query);

// Remove existing 'page' parameter if it exists
        unset($query['page']);

// Function to build the new URL with page
        function buildPageLink($path, $query, $page)
        {
            $query['page'] = $page;
            return $path . '?' . http_build_query($query);
        }

// Previous Page Button
        $prevPage = ($paginatedData->current_page > 1) ? $paginatedData->current_page - 1 : 1;
        $html .= '<li class="page-item">';
        $html .= '<a class="page-link" href="' . url(ltrim(buildPageLink($path, $query, $prevPage), '/')) . '"><i class="fa-solid fa-chevron-left"></i></a>';
        $html .= '</li>';

// Page Numbers
       if($paginatedData->total_pages > 0 && $paginatedData->total_pages < 5)
       {
           if ($paginatedData->total_pages >= 1) {
               for ($page = 1; $page <= $paginatedData->total_pages; $page++) {
                   $activeClass = ($page == $paginatedData->current_page) ? ' active' : '';
                   $html .= '<li class="page-item' . $activeClass . '">';
                   $html .= '<a class="page-link" href="' . url(ltrim(buildPageLink($path, $query, $page), '/')) . '">' . $page . '</a>';
                   $html .= '</li>';
               }
           }
       }

// Next Page Button
        $nextPage = ($paginatedData->current_page < $paginatedData->total_pages) ? $paginatedData->current_page + 1 : $paginatedData->total_pages;
        $html .= '<li class="page-item">';
        $html .= '<a class="page-link" href="' . url(ltrim(buildPageLink($path, $query, $nextPage), '/')) . '"><i class="fa-solid fa-chevron-right"></i></a>';
        $html .= '</li>';

        $html .= '</ul>';


                $showingFrom = ($paginatedData->current_page - 1) * $paginatedData->row_per_page + 1;
        $showingTo = min($paginatedData->current_page * $paginatedData->row_per_page, $paginatedData->total_records);
        $total = $paginatedData->total_records;


                $newhtml = '<div class="d-flex justify-content-between align-items-center paginator-wrapper mt-5 mb-5">';
        $newhtml .= '<div class="bg-w paginator-info"> <span class="me-2">
                        <i class="fa-solid fa-globe"></i></span>';
        $newhtml .= "Show $showingFrom to $showingTo of $total entries </div>";
        $newhtml .= $html;

        return ($newhtml);

    }
}