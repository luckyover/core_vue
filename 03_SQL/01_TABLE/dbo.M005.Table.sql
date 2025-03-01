/****** Object:  Table [dbo].[M005]    Script Date: 2024/02/19 0:05:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[M005](
	[delivery_cd] [int] NOT NULL,
	[delivery_nm] [nvarchar](50) NULL,
	[delivery_kn_nm] [nvarchar](50) NULL,
	[delivery_ab_nm] [nvarchar](30) NULL,
	[delivery_zip] [nvarchar](8) NULL,
	[delivery_address1] [nvarchar](50) NULL,
	[delivery_address2] [nvarchar](50) NULL,
	[delivery_address3] [nvarchar](100) NULL,
	[delivery_tel] [nvarchar](20) NULL,
	[delivery_fax] [nvarchar](20) NULL,
	[delivery_department_nm] [nvarchar](30) NULL,
	[delivery_manager_nm] [nvarchar](30) NULL,
	[delivery_mail_address] [nvarchar](255) NULL,
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
 CONSTRAINT [PK_m_delivery] PRIMARY KEY CLUSTERED 
(
	[delivery_cd] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
