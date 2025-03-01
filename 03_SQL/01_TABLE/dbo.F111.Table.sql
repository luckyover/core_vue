/****** Object:  Table [dbo].[F111]    Script Date: 2024/02/19 0:05:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[F111](
	[processing_order_no] [nvarchar](8) NOT NULL,
	[project_no] [nvarchar](8) NULL,
	[order_date] [date] NULL,
	[delivery_div] [smallint] NULL,
	[process_status_div] [smallint] NULL,
	[order_employee_cd] [nvarchar](5) NULL,
	[supplier_cd] [nvarchar](8) NULL,
	[supplier_department_nm] [nvarchar](30) NULL,
	[order_placement_div] [smallint] NULL,
	[order_placement_instruction_div] [smallint] NULL,
	[change_div] [smallint] NULL,
	[body_introduction_date] [date] NULL,
	[name_introduction_date] [date] NULL,
	[jan_introduction_date] [date] NULL,
	[etc_introduction_date_lbl] [nvarchar](30) NULL,
	[etc_introduction_date] [date] NULL,
	[remarks] [nvarchar](400) NULL,
	[processing_instruct_attached_file_no] [int] NULL,
	[body_arrival_date] [date] NULL,
	[material_arrival_date] [date] NULL,
	[photo_confirm_date] [date] NULL,
	[photo_attached_file_no] [int] NULL,
	[invoice_attached_file_no] [int] NULL,
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
 CONSTRAINT [PK_t_item_order_delivery_d] PRIMARY KEY CLUSTERED 
(
	[processing_order_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
