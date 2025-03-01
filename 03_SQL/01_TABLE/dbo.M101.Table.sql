/****** Object:  Table [dbo].[M101]    Script Date: 2024/02/19 0:05:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[M101](
	[item_cd] [nvarchar](30) NOT NULL,
	[color_cd] [nvarchar](10) NOT NULL,
	[item_nm] [nvarchar](50) NULL,
	[item_kn_nm] [nvarchar](50) NULL,
	[item_ab_nm] [nvarchar](30) NULL,
	[color_nm] [nvarchar](30) NULL,
	[color_kn_nm] [nvarchar](30) NULL,
	[color_ab_nm] [nvarchar](20) NULL,
	[item_class_div] [smallint] NULL,
	[process_div] [smallint] NULL,
	[category_div] [smallint] NULL,
	[material_div] [smallint] NULL,
	[supplier_cd] [nvarchar](8) NULL,
	[supplier_item_cd] [nvarchar](30) NULL,
	[tax_div] [smallint] NULL,
	[remarks] [nvarchar](100) NULL,
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
 CONSTRAINT [PK_m_item] PRIMARY KEY CLUSTERED 
(
	[item_cd] ASC,
	[color_cd] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
