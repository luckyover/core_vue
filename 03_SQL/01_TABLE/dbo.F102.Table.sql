/****** Object:  Table [dbo].[F102]    Script Date: 2024/02/19 0:05:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[F102](
	[item_order_no] [nvarchar](8) NOT NULL,
	[delivery_row_no] [nvarchar](8) NOT NULL,
	[delivery_div] [smallint] NULL,
	[delivery_cd] [int] NULL,
	[delivery_nm] [nvarchar](50) NULL,
	[delivery_zip] [nvarchar](8) NULL,
	[delivery_address1] [nvarchar](50) NULL,
	[delivery_address2] [nvarchar](50) NULL,
	[delivery_address3] [nvarchar](100) NULL,
	[delivery_tel] [nvarchar](20) NULL,
	[delivery_fax] [nvarchar](20) NULL,
	[delivery_department_nm] [nvarchar](30) NULL,
	[delivery_manager_nm] [nvarchar](30) NULL,
	[delivery_mail_address] [nvarchar](255) NULL,
	[shipper_div] [smallint] NULL,
	[shipper_cd] [int] NULL,
	[shipper_nm] [nvarchar](50) NULL,
	[shipper_zip] [nvarchar](8) NULL,
	[shipper_address1] [nvarchar](50) NULL,
	[shipper_address2] [nvarchar](50) NULL,
	[shipper_address3] [nvarchar](100) NULL,
	[shipper_tel] [nvarchar](20) NULL,
	[shipper_fax] [nvarchar](20) NULL,
	[shipper_department_nm] [nvarchar](30) NULL,
	[shipper_manager_nm] [nvarchar](30) NULL,
	[shipper_mail_address] [nvarchar](255) NULL,
	[sch_ship_date] [date] NULL,
	[spc_delivery_date] [date] NULL,
	[spc_delivery_div] [smallint] NULL,
	[delivery_company_div] [smallint] NULL,
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
 CONSTRAINT [PK_t_invoice_d] PRIMARY KEY CLUSTERED 
(
	[item_order_no] ASC,
	[delivery_row_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
