const sampleView = [
  {
    id: "sample",
    title: "Sample Page",
    layout: [
      {
        metrics: [
          "screenPageViews"
        ],
        type: "views",
        compare: true,
        id: "views-1765195265252-0",
        title: "Page Views",
        position: {
          x: 0,
          y: 0,
          w: 1
        }
      },
      {
        metrics: [
          "totalUsers"
        ],
        type: "total-users",
        compare: true,
        id: "total-users-1765195265252-1",
        title: "Total Users",
        position: {
          x: 1,
          y: 0,
          w: 1
        }
      },
      {
        metrics: [
          "sessions"
        ],
        type: "sessions",
        compare: true,
        id: "sessions-1765195265252-5",
        title: "Sessions",
        position: {
          x: 2,
          y: 0,
          w: 1
        }
      },
      {
        metrics: [
          "screenPageViews"
        ],
        type: "views",
        compare: true,
        displayType: "line-chart",
        id: "views-1765195265252-6",
        title: "Page Views Over Time",
        position: {
          x: 0,
          y: 1,
          w: 3
        }
      },
      {
        type: "author",
        limit: 10,
        id: "author-1765195265252-7",
        title: "Top Authors",
        position: {
          x: 0,
          y: 2,
          w: 1
        }
      },
      {
        type: "organic-search",
        limit: 10,
        id: "organic-search-1765195265252-8",
        title: "Organic Search",
        position: {
          x: 1,
          y: 2,
          w: 1
        }
      },
      {
        type: "social-media",
        limit: 10,
        id: "social-media-1765195265252-9",
        title: "Social Media",
        position: {
          x: 2,
          y: 2,
          w: 1
        }
      }
    ],
    menu_order: 1
  }
];
export {
  sampleView as default
};
