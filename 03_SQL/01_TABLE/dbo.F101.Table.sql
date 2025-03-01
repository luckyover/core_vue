/****** Object:  Table [dbo].[F101]    Script Date: 2024/02/19 0:05:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[F101](
	[item_order_no] [nvarchar](8) NOT NULL,
	[project_no] [nvarchar](8) NULL,
	[order_date] [date] NULL,
	[delivery_div] [smallint] NULL,
	[order_status_div] [smallint] NULL,
	[order_employee_cd] [nvarchar](5) NULL,
	[supplier_cd] [nvarchar](8) NULL,
	[supplier_department_nm] [nvarchar](30) NULL,
	[contact_column_div] [smallint] NULL,
	[contact_column] [nvarchar](200) NULL,
	[shipment_completed_date] [date] NULL,
	[invoice_attached_file_no] [int] NULL,
	[remarks] [nvarchar](400) NULL,
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
 CONSTRAINT [PK_t_invoice_h] PRIMARY KEY CLUSTERED 
(
	[item_order_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
