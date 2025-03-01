/****** Object:  Table [dbo].[F032]    Script Date: 2024/02/19 0:05:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[F032](
	[sales_no] [nvarchar](8) NOT NULL,
	[sales_row_no] [int] NOT NULL,
	[item_cd] [nvarchar](30) NULL,
	[color_cd] [nvarchar](10) NULL,
	[size] [nvarchar](10) NULL,
	[supplier_cd] [nvarchar](8) NULL,
	[item_nm] [nvarchar](50) NULL,
	[item_nm2] [nvarchar](50) NULL,
	[body_item_cd] [nvarchar](30) NULL,
	[body_color_cd] [nvarchar](10) NULL,
	[body_arrangement_div] [smallint] NOT NULL,
	[category_div] [smallint] NULL,
	[material_div] [smallint] NULL,
	[processing_place_div] [smallint] NULL,
	[number_of_color_div] [smallint] NULL,
	[qty] [money] NULL,
	[upr] [money] NULL,
	[amt] [money] NULL,
	[remarks] [nvarchar](100) NULL,
	[disp_order] [int] NULL,
	[cre_user_cd] [nvarchar](5) NULL,
	[cre_prg] [nvarchar](30) NULL,
	[cre_ip] [nvarchar](20) NULL,
	[cre_tm] [datetime2](7) NULL,
	[upd_user_cd] [nvarchar](5) NULL,
	[upd_prg] [nvarchar](30) NULL,
	[upd_ip] [nvarchar](20) NULL,
	[upd_tm] [datetime2](7) NULL,
	[del_user_cd] [nvarchar](5) NULL,
	[del_prg] [nvarchar](30) NULL,
	[del_ip] [nvarchar](20) NULL,
	[del_tm] [datetime2](7) NULL,
	[del_flg] [int] NULL,
 CONSTRAINT [PK_t_sales_d] PRIMARY KEY CLUSTERED 
(
	[sales_no] ASC,
	[sales_row_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
