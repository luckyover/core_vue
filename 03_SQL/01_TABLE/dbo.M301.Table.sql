/****** Object:  Table [dbo].[M301]    Script Date: 2024/02/19 0:05:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[M301](
	[item_cd] [nvarchar](30) NOT NULL,
	[category_div] [smallint] NOT NULL,
	[material_div] [smallint] NOT NULL,
	[processing_place_div] [smallint] NOT NULL,
	[number_sheet_fr] [money] NOT NULL,
	[number_sheet_to] [money] NOT NULL,
	[color_div] [smallint] NOT NULL,
	[sales_amt] [money] NULL,
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
 CONSTRAINT [PK_m_process_price] PRIMARY KEY CLUSTERED 
(
	[item_cd] ASC,
	[category_div] ASC,
	[material_div] ASC,
	[processing_place_div] ASC,
	[number_sheet_fr] ASC,
	[number_sheet_to] ASC,
	[color_div] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
